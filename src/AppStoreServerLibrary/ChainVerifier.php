<?php

namespace AppStoreServerLibrary;

use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\SignedDataVerifier\VerificationException;
use AppStoreServerLibrary\SignedDataVerifier\VerificationStatus;
use AppStoreServerLibrary\X509\Certificate;
use DateTime;
use DomainException;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use InvalidArgumentException;
use OCSP\Certificate\CertificateLoader;
use OCSP\Exceptions\OcspCertificateException;
use OCSP\Exceptions\OcspResponseDecodeException;
use OCSP\Exceptions\OcspVerifyFailedException;
use OCSP\OcspRequest;
use OCSP\OcspResponse;
use OpenSSLAsymmetricKey;
use phpseclib3\File\X509;
use stdClass;

class ChainVerifier
{
    const EXPECTED_CHAIN_LENGTH = 3;
    const EXPECTED_JWT_SEGMENTS = 3;
    const EXPECTED_ALGORITHM = "ES256";

    const APPLE_EXTENSION_MAC_APP_STORE_RECEIPT_SIGNING = "1.2.840.113635.100.6.11.1";
    const APPLE_EXTENSION_WWDR_INTERMEDIATE = "1.2.840.113635.100.6.2.1";


    /** @var Certificate[] */
    private readonly array $rootCertificates;


    /**
     * @param string[] $rootCertificates
     * @throws VerificationException
     */
    public function __construct(
        array $rootCertificates,
    ) {
        try {
            $this->rootCertificates = array_map(
                fn ($rootCertificate) => Certificate::fromDER($rootCertificate),
                $rootCertificates
            );
        } catch (Exception) {
            throw new VerificationException(VerificationStatus::INVALID_CERTIFICATE);
        }
    }

    /**
     * @throws VerificationException
     */
    public function verify(string $signedData, bool $performOnlineChecks, Environment $environment): stdClass
    {
        $bodySegments = explode(".", $signedData);
        if (count($bodySegments) !== self::EXPECTED_JWT_SEGMENTS) {
            throw new VerificationException(VerificationStatus::INVALID_JWT_FORMAT);
        }
        [$headersBase64, $payloadBase64] = $bodySegments;
        try {
            $headersRaw = JWT::urlsafeB64Decode($headersBase64);
            $bodyRaw = JWT::urlsafeB64Decode($payloadBase64);
            $unverifiedHeaders = JWT::jsonDecode($headersRaw);
            $body = JWT::jsonDecode($bodyRaw);
        } catch (InvalidArgumentException|DomainException) {
            throw new VerificationException(VerificationStatus::INVALID_JWT_FORMAT);
        }
        if (is_array($unverifiedHeaders)) {
            $unverifiedHeaders = (object)$unverifiedHeaders;
        }
        if (is_array($body)) {
            $body = (object)$body;
        }
        if (!$unverifiedHeaders instanceof stdClass || !$body instanceof stdClass) {
            throw new VerificationException(VerificationStatus::INVALID_JWT_FORMAT);
        }

        if ($environment === Environment::XCODE || $environment === Environment::LOCAL_TESTING) {
            // Data is not signed by the App Store, and verification should be skipped
            // The environment MUST be checked in the public method calling this
            return $body;
        }

        $x5cHeader = $unverifiedHeaders->x5c ?? null;
        $algorithmHeader = $unverifiedHeaders->alg ?? null;
        if ($algorithmHeader !== self::EXPECTED_ALGORITHM
            || !is_array($x5cHeader)
            || count($x5cHeader) !== self::EXPECTED_CHAIN_LENGTH) {
            throw new VerificationException(VerificationStatus::INVALID_JWT_FORMAT);
        }

        try {
            $leafCertificate = Certificate::fromDER($x5cHeader[0], isBase64Encoded: true);
            $intermediateCertificate = Certificate::fromDER($x5cHeader[1], isBase64Encoded: true);
        } catch (Exception) {
            throw new VerificationException(VerificationStatus::INVALID_CERTIFICATE);
        }
        $signedDate = $body->signedDate ?? $body->receiptCreationDate ?? null;
        $effectiveDate = $performOnlineChecks || !is_int($signedDate)
            ? new DateTime() : (new DateTime())->setTimestamp(intval(floor($signedDate / 1000)));

        $publicKey = $this->verifyChain(
            leafCertificate: $leafCertificate,
            intermediateCertificate: $intermediateCertificate,
            performOnlineChecks: $performOnlineChecks,
            effectiveDate: $effectiveDate
        );

        return JWT::decode($signedData, new Key($publicKey, algorithm: self::EXPECTED_ALGORITHM));
    }

    /**
     * @throws VerificationException
     */
    public function verifyChain(
        Certificate $leafCertificate,
        Certificate $intermediateCertificate,
        bool $performOnlineChecks,
        DateTime $effectiveDate
    ): OpenSSLAsymmetricKey {
        if (empty($this->rootCertificates)) {
            throw new VerificationException(VerificationStatus::INVALID_CERTIFICATE);
        }

        // check that leaf was signed by intermediate
        $isValid = $leafCertificate->verify(
            publicKey: $intermediateCertificate->getOpenSSLCertificate(),
            effectiveTime: $effectiveDate
        );
        if (!$isValid) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // check that intermediate was signed by any of the trusted roots
        $usedRootCertificate = null;
        foreach ($this->rootCertificates as $rootCertificate) {
            $isValid = $intermediateCertificate->verify(
                publicKey: $rootCertificate->getOpenSSLCertificate(),
                effectiveTime: $effectiveDate
            );
            if ($isValid) {
                $usedRootCertificate = $rootCertificate;
                break;
            }
        }
        if ($usedRootCertificate === null) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // verify expected extensions are given
        if (!$leafCertificate->hasExtension(self::APPLE_EXTENSION_MAC_APP_STORE_RECEIPT_SIGNING)
            || !$intermediateCertificate->hasExtension(self::APPLE_EXTENSION_WWDR_INTERMEDIATE)
        ) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // optionally, check OCSP status
        if ($performOnlineChecks) {
            $this->checkOcspStatus(
                cert: $intermediateCertificate,
                issuer: $usedRootCertificate,
                root: $usedRootCertificate
            );
            $this->checkOcspStatus(
                cert: $leafCertificate,
                issuer: $intermediateCertificate,
                root: $usedRootCertificate
            );
        }

        return $leafCertificate->getOpenSSLPublicKey();
    }

    /**
     * @throws VerificationException
     */
    private function checkOcspStatus(Certificate $cert, Certificate $issuer, Certificate $root): void
    {
        $ocspResponderUri = $cert->getOcspUri();
        if ($ocspResponderUri === null) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // generate OCSP request
        try {
            $certX509 = CertificateLoader::fromString($cert->getPem());
            $issuerX509 = CertificateLoader::fromString($issuer->getPem());
            $certificateId = CertificateLoader::generateCertificateId($certX509, $issuerX509);
        } catch (OcspCertificateException) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }
        $ocspRequest = new OcspRequest();
        $ocspRequest->addCertificateId($certificateId);

        // perform request and check that response has HTTP 200 status and expected Content-Type
        $ocspClient = new Client([
            RequestOptions::TIMEOUT => 30,
            RequestOptions::CONNECT_TIMEOUT => 30,
            RequestOptions::HTTP_ERRORS => false,
        ]);
        try {
            $response = $ocspClient->request(
                method: "POST",
                uri: $ocspResponderUri,
                options: [
                    RequestOptions::BODY => $ocspRequest->getEncodeDer(),
                    RequestOptions::HEADERS => [
                        "Content-Type" => OcspRequest::CONTENT_TYPE,
                    ],
                ]
            );
        } catch (GuzzleException) {
            // may occur when no connection can be established
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }
        if ($response->getStatusCode() !== 200
            || $response->getHeaderLine("Content-Type") !== OcspResponse::CONTENT_TYPE
        ) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // - Decode OCSP response.
        // - Validate certificate ID equals the one from the request:
        //   Consists of hash algorithm, issuer name hash, issuer key hash, and serial number.
        // - Validate signature (always uses first certificate of array in response).
        try {
            $ocspResponse = new OcspResponse((string)$response->getBody());
            $ocspResponse->validateCertificateId($certificateId);
            $ocspResponse->validateSignature();
            $isRevoked = $ocspResponse->isRevoked();
        } catch (OcspCertificateException|OcspResponseDecodeException|OcspVerifyFailedException) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // check that certificate is still valid (explicitly not revoked)
        if ($isRevoked !== false) {
            throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
        }

        // validate that signing certificate is trusted
        /** @var X509 $signingCert */
        $signingCert = $ocspResponse->getBasicResponse()->getCertificates()[0];
        if ($signingCert->getCurrentCert() === $issuerX509->getCurrentCert()) {
            // signing certificate equals issuer, which is trusted
            return;
        } else {
            // load issuer and root certificates into trusted store and validate signature
            foreach ([$issuer, $root] as $trustedCert) {
                if (!$signingCert->loadCA($trustedCert->getPem())) {
                    throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
                }
            }
            if (!$signingCert->validateSignature()) {
                throw new VerificationException(VerificationStatus::VERIFICATION_FAILURE);
            }
        }
    }
}
