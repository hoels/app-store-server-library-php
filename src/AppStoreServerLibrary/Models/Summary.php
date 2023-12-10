<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The payload data for a subscription-renewal-date extension notification.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/summary
 */
class Summary
{
    /**
     * @param string[]|null $storefrontCountryCodes
     */
    public function __construct(
        private readonly ?Environment $environment,
        private readonly ?int $appAppleId,
        private readonly ?string $bundleId,
        private readonly ?string $productId,
        private readonly ?string $requestIdentifier,
        private readonly ?array $storefrontCountryCodes,
        private readonly ?int $succeededCount,
        private readonly ?int $failedCount,
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
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * A string that contains a unique identifier you provide to track each subscription-renewal-date extension request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public function getRequestIdentifier(): ?string
    {
        return $this->requestIdentifier;
    }

    /**
     * A list of storefront country codes you provide to limit the storefronts for a subscription-renewal-date
     * extension.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/storefrontcountrycodes
     *
     * @return string[]|null
     */
    public function getStorefrontCountryCodes(): ?array
    {
        return $this->storefrontCountryCodes;
    }

    /**
     * The count of subscriptions that successfully receive a subscription-renewal-date extension.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/succeededcount
     */
    public function getSucceededCount(): ?int
    {
        return $this->succeededCount;
    }

    /**
     * The count of subscriptions that fail to receive a subscription-renewal-date extension.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/failedcount
     */
    public function getFailedCount(): ?int
    {
        return $this->failedCount;
    }

    public static function fromObject(stdClass $obj): Summary
    {
        return new Summary(
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            productId: property_exists($obj, "productId") && is_string($obj->productId)
                ? $obj->productId : null,
            requestIdentifier: property_exists($obj, "requestIdentifier") && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null,
            storefrontCountryCodes: property_exists($obj, "storefrontCountryCodes")
                && is_array($obj->storefrontCountryCodes)
                ? array_filter(
                    $obj->storefrontCountryCodes,
                    fn($storefrontCountryCode) => is_string($storefrontCountryCode)
                ) : null,
            succeededCount: property_exists($obj, "succeededCount") && is_int($obj->succeededCount)
                ? $obj->succeededCount : null,
            failedCount: property_exists($obj, "failedCount") && is_int($obj->failedCount)
                ? $obj->failedCount : null
        );
    }
}
