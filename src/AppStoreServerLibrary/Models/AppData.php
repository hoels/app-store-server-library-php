<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The object that contains the app metadata and signed app transaction information.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/appdata
 */
class AppData
{
    public function __construct(
        private readonly ?int $appAppleId,
        private readonly ?string $bundleId,
        private readonly ?Environment $environment,
        private readonly ?string $signedAppTransactionInfo,
    ) {
    }

    /**
     * The unique identifier of the app that the notification applies to.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/appappleid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * The bundle identifier of the app.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/bundleid
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
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
     * App transaction information signed by the App Store, in JSON Web Signature (JWS) Compact Serialization format.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/jwsapptransaction
     */
    public function getSignedAppTransactionInfo(): ?string
    {
        return $this->signedAppTransactionInfo;
    }

    public static function fromObject(stdClass $obj): AppData
    {
        return new AppData(
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            signedAppTransactionInfo: property_exists($obj, "signedAppTransactionInfo")
                && is_string($obj->signedAppTransactionInfo)
                ? $obj->signedAppTransactionInfo : null,
        );
    }
}
