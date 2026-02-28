<?php

namespace AppStoreServerLibrary\X509;

use DateTime;
use Exception;
use OpenSSLAsymmetricKey;
use OpenSSLCertificate;

class Certificate
{
    /**
     * @param array<string, string> $extensions
     */
    public function __construct(
        private readonly DateTime $notValidBefore,
        private readonly DateTime $notValidAfter,
        private readonly array $extensions,
        private readonly string $pem,
        private readonly OpenSSLCertificate $openSSLCertificate,
        private readonly OpenSSLAsymmetricKey $openSSLPublicKey,
    ) {
    }

    public function getNotValidBefore(): DateTime
    {
        return $this->notValidBefore;
    }

    public function getNotValidAfter(): DateTime
    {
        return $this->notValidAfter;
    }

    /**
     * @return array<string, string>
     */
    public function getExtensions(): array
    {
        return $this->extensions;
    }

    public function hasExtension(string $name): bool
    {
        return array_key_exists($name, $this->extensions);
    }

    public function getExtension(string $name): ?string
    {
        return $this->extensions[$name] ?? null;
    }

    public function getOcspUri(): ?string
    {
        $authorityInfoAccess = $this->extensions["authorityInfoAccess"] ?? null;
        if ($authorityInfoAccess !== null
            && preg_match("/OCSP - URI:(.*?)(\n|$)/", $authorityInfoAccess, $matches) === 1
        ) {
            return $matches[1];
        } else {
            return null;
        }
    }

    public function getOpenSSLCertificate(): OpenSSLCertificate
    {
        return $this->openSSLCertificate;
    }

    public function getOpenSSLPublicKey(): OpenSSLAsymmetricKey
    {
        return $this->openSSLPublicKey;
    }

    public function getPem(): string
    {
        return $this->pem;
    }

    public function verify(OpenSSLCertificate|OpenSSLAsymmetricKey $publicKey, ?DateTime $effectiveTime = null): bool
    {
        $effectiveTime = $effectiveTime ?? new DateTime();
        return $this->notValidBefore < $effectiveTime
            && $this->notValidAfter > $effectiveTime
            && openssl_x509_verify(certificate: $this->openSSLCertificate, public_key: $publicKey) === 1;
    }

    /**
     * @throws Exception
     */
    public static function fromDER(string $der, bool $isBase64Encoded = false): Certificate
    {
        $base64EncodedDER = $isBase64Encoded ? $der : base64_encode($der);
        $pem = "-----BEGIN CERTIFICATE-----" . PHP_EOL
            . chunk_split(string: $base64EncodedDER, length: 64, separator: PHP_EOL)
            . "-----END CERTIFICATE-----" . PHP_EOL;
        return self::fromPEM($pem);
    }

    /**
     * @throws Exception
     */
    public static function fromPEM(string $pem): Certificate
    {
        $data = openssl_x509_parse($pem);
        if ($data === false) {
            throw new Exception("Invalid certificate.");
        }

        /** @var int $notValidBeforeTimestamp */
        $notValidBeforeTimestamp = $data["validFrom_time_t"];
        /** @var int $notValidAfterTimestamp */
        $notValidAfterTimestamp = $data["validTo_time_t"];
        /** @var array<string, string> $extensions */
        $extensions = $data["extensions"];

        $notValidBefore = (new DateTime())->setTimestamp($notValidBeforeTimestamp);
        $notValidAfter = (new DateTime())->setTimestamp($notValidAfterTimestamp);
        $openSSLCertificate = openssl_x509_read($pem);
        if ($openSSLCertificate === false) {
            throw new Exception("Invalid certificate.");
        }
        $openSSLPublicKey = openssl_pkey_get_public($openSSLCertificate);
        if ($openSSLPublicKey === false) {
            throw new Exception("Invalid certificate.");
        }

        return new Certificate(
            notValidBefore: $notValidBefore,
            notValidAfter: $notValidAfter,
            extensions: $extensions,
            pem: $pem,
            openSSLCertificate: $openSSLCertificate,
            openSSLPublicKey: $openSSLPublicKey
        );
    }
}
