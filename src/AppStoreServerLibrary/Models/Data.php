<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The app metadata and the signed renewal and transaction information.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/data
 */
class Data
{
    public function __construct(
        private readonly ?Environment $environment,
        private readonly ?int $appAppleId,
        private readonly ?string $bundleId,
        private readonly ?string $bundleVersion,
        private readonly ?string $signedTransactionInfo,
        private readonly ?string $signedRenewalInfo,
        private readonly ?Status $status,
    ) {
    }

    /**
     * The server environment that the notification applies to, either sandbox or production.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    /**
     * The unique identifier of an app in the App Store.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/appappleid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * The bundle identifier of an app.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
    }

    /**
     * The version of the build that identifies an iteration of the bundle.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/bundleversion
     */
    public function getBundleVersion(): ?string
    {
        return $this->bundleVersion;
    }

    /**
     * Transaction information signed by the App Store, in JSON Web Signature (JWS) format.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     */
    public function getSignedTransactionInfo(): ?string
    {
        return $this->signedTransactionInfo;
    }

    /**
     * Subscription renewal information, signed by the App Store, in JSON Web Signature (JWS) format.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfo
     */
    public function getSignedRenewalInfo(): ?string
    {
        return $this->signedRenewalInfo;
    }

    /**
     * The status of an auto-renewable subscription as of the signedDate in the responseBodyV2DecodedPayload.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/status
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public static function fromObject(stdClass $obj): Data
    {
        return new Data(
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            bundleVersion: property_exists($obj, "bundleVersion") && is_string($obj->bundleVersion)
                ? $obj->bundleVersion : null,
            signedTransactionInfo: property_exists($obj, "signedTransactionInfo")
                && is_string($obj->signedTransactionInfo)
                ? $obj->signedTransactionInfo : null,
            signedRenewalInfo: property_exists($obj, "signedRenewalInfo") && is_string($obj->signedRenewalInfo)
                ? $obj->signedRenewalInfo : null,
            status: property_exists($obj, "status") && is_int($obj->status)
                ? Status::tryFrom($obj->status) : null
        );
    }
}
