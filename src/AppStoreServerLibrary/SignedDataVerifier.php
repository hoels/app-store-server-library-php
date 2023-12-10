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

class SignedDataVerifier
{
    private readonly ChainVerifier $chainVerifier;


    /**
     * @param string[] $rootCertificates
     * @throws VerificationException
     */
    public function __construct(
        private readonly array $rootCertificates,
        private readonly bool $enableOnlineChecks,
        private readonly Environment $environment,
        private readonly string $bundleId,
        private readonly ?int $appAppleId = null,
    ) {
        $this->chainVerifier = new ChainVerifier($this->rootCertificates);
    }

    /**
     * Verifies and decodes a signedRenewalInfo obtained from the App Store Server API, an App Store Server
     * Notification, or from a device
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
        if ($decodedSignedNotification->getData() !== null) {
            $bundleId = $decodedSignedNotification->getData()->getBundleId();
            $appAppleId = $decodedSignedNotification->getData()->getAppAppleId();
            $environment = $decodedSignedNotification->getData()->getEnvironment();
        } elseif ($decodedSignedNotification->getSummary() !== null) {
            $bundleId = $decodedSignedNotification->getSummary()->getBundleId();
            $appAppleId = $decodedSignedNotification->getSummary()->getAppAppleId();
            $environment = $decodedSignedNotification->getSummary()->getEnvironment();
        }
        if ($bundleId !== $this->bundleId
            || ($this->environment === Environment::PRODUCTION
                && $appAppleId !== $this->appAppleId)
        ) {
            throw new VerificationException(VerificationStatus::INVALID_APP_IDENTIFIER);
        }
        if ($environment !== $this->environment) {
            throw new VerificationException(VerificationStatus::INVALID_ENVIRONMENT);
        }
        return $decodedSignedNotification;
    }

    /**
     * Verifies and decodes a signed AppTransaction
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
