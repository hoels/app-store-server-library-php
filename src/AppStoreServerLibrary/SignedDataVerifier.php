<?php

namespace AppStoreServerLibrary;

use AppStoreServerLibrary\Models\AppTransaction;
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\Models\JWSRenewalInfoDecodedPayload;
use AppStoreServerLibrary\Models\JWSTransactionDecodedPayload;
use AppStoreServerLibrary\Models\ResponseBodyV2DecodedPayload;
use AppStoreServerLibrary\SignedDataVerifier\VerificationException;
use AppStoreServerLibrary\SignedDataVerifier\VerificationStatus;
use stdClass;
use ValueError;

class SignedDataVerifier
{
    private readonly ChainVerifier $chainVerifier;


    /**
     * @param string[] $rootCertificates
     * @throws VerificationException|ValueError
     */
    public function __construct(
        private readonly array $rootCertificates,
        private readonly bool $enableOnlineChecks,
        private readonly Environment $environment,
        private readonly string $bundleId,
        private readonly ?int $appAppleId = null,
    ) {
        $this->chainVerifier = new ChainVerifier($this->rootCertificates);
        if ($environment === Environment::PRODUCTION && $this->appAppleId === null) {
            throw new ValueError("appAppleId is required when the environment is Production");
        }
    }

    /**
     * Verifies and decodes a signedRenewalInfo obtained from the App Store Server API, an App Store Server
     * Notification, or from a device
     * See https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfo
     *
     * @param string $signedRenewalInfo The signedRenewalInfo field
     * @return JWSRenewalInfoDecodedPayload The decoded renewal info after verification
     * @throws VerificationException Thrown if the data could not be verified
     */
    public function verifyAndDecodeRenewalInfo(string $signedRenewalInfo): JWSRenewalInfoDecodedPayload
    {
        $decodedRenewalInfo = JWSRenewalInfoDecodedPayload::fromObject($this->decodeSignedObject($signedRenewalInfo));
        if ($decodedRenewalInfo->getEnvironment() !== $this->environment) {
            throw new VerificationException(VerificationStatus::INVALID_ENVIRONMENT);
        }
        return $decodedRenewalInfo;
    }

    /**
     * Verifies and decodes a signedTransaction obtained from the App Store Server API, an App Store Server
     * Notification, or from a device
     * See https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     *
     * @param string $signedTransaction The signedRenewalInfo field
     * @return JWSTransactionDecodedPayload The decoded transaction info after verification
     * @throws VerificationException Thrown if the data could not be verified
     */
    public function verifyAndDecodeSignedTransaction(string $signedTransaction): JWSTransactionDecodedPayload
    {
        $decodedTransactionInfo = JWSTransactionDecodedPayload::fromObject(
            $this->decodeSignedObject($signedTransaction)
        );
        if ($decodedTransactionInfo->getEnvironment() !== $this->environment) {
            throw new VerificationException(VerificationStatus::INVALID_ENVIRONMENT);
        }
        return $decodedTransactionInfo;
    }

    /**
     * Verifies and decodes an App Store Server Notification signedPayload
     * See https://developer.apple.com/documentation/appstoreservernotifications/signedpayload
     *
     * @param string $signedPayload The payload received by your server
     * @return ResponseBodyV2DecodedPayload The decoded payload after verification
     * @throws VerificationException Thrown if the data could not be verified
     */
    public function verifyAndDecodeNotification(string $signedPayload): ResponseBodyV2DecodedPayload
    {
        $decodedSignedNotification = ResponseBodyV2DecodedPayload::fromObject(
            $this->decodeSignedObject($signedPayload)
        );
        $bundleId = null;
        $appAppleId = null;
        $environment = null;
        if (($data = $decodedSignedNotification->getData()) !== null) {
            $bundleId = $data->getBundleId();
            $appAppleId = $data->getAppAppleId();
            $environment = $data->getEnvironment();
        } elseif (($summary = $decodedSignedNotification->getSummary()) !== null) {
            $bundleId = $summary->getBundleId();
            $appAppleId = $summary->getAppAppleId();
            $environment = $summary->getEnvironment();
        } elseif (($externalPurchaseToken = $decodedSignedNotification->getExternalPurchaseToken()) !== null) {
            $bundleId = $externalPurchaseToken->getBundleId();
            $appAppleId = $externalPurchaseToken->getAppAppleId();
            if (($externalPurchaseId = $externalPurchaseToken->getExternalPurchaseId()) !== null
                && str_starts_with($externalPurchaseId, "SANDBOX")) {
                $environment = Environment::SANDBOX;
            } else {
                $environment = Environment::PRODUCTION;
            }
        }

        $this->verifyNotification(bundleId: $bundleId, appAppleId: $appAppleId, environment: $environment);

        return $decodedSignedNotification;
    }

    /**
     * @throws VerificationException
     */
    public function verifyNotification(?string $bundleId, ?int $appAppleId, ?Environment $environment): void {
        if ($bundleId !== $this->bundleId
            || ($this->environment === Environment::PRODUCTION
                && $appAppleId !== $this->appAppleId)
        ) {
            throw new VerificationException(VerificationStatus::INVALID_APP_IDENTIFIER);
        }
        if ($environment !== $this->environment) {
            throw new VerificationException(VerificationStatus::INVALID_ENVIRONMENT);
        }
    }

    /**
     * Verifies and decodes a signed AppTransaction
     * See https://developer.apple.com/documentation/storekit/apptransaction
     *
     * @param string $signedAppTransaction The signed AppTransaction
     * @return AppTransaction The decoded AppTransaction after validation
     * @throws VerificationException Thrown if the data could not be verified
     */
    public function verifyAndDecodeAppTransaction(string $signedAppTransaction): AppTransaction
    {
        $decodedAppTransaction = AppTransaction::fromObject($this->decodeSignedObject($signedAppTransaction));
        if ($decodedAppTransaction->getBundleId() !== $this->bundleId
            || ($this->environment === Environment::PRODUCTION
                && $decodedAppTransaction->getAppAppleId() !== $this->appAppleId)
        ) {
            throw new VerificationException(VerificationStatus::INVALID_APP_IDENTIFIER);
        }
        if ($decodedAppTransaction->getReceiptType() !== $this->environment) {
            throw new VerificationException(VerificationStatus::INVALID_ENVIRONMENT);
        }
        return $decodedAppTransaction;
    }

    /**
     * @throws VerificationException
     */
    private function decodeSignedObject(string $signedData): stdClass
    {
        return $this->chainVerifier->verify(
            signedData: $signedData,
            performOnlineChecks: $this->enableOnlineChecks,
            environment: $this->environment
        );
    }
}
