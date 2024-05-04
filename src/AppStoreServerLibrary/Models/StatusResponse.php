<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains status information for all of a customer's auto-renewable subscriptions in your app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/statusresponse
 */
class StatusResponse
{
    /**
     * @param SubscriptionGroupIdentifierItem[]|null $data
     */
    public function __construct(
        private readonly ?Environment $environment,
        private readonly ?string $bundleId,
        private readonly ?int $appAppleId,
        private readonly ?array $data,
    ) {
    }

    /**
     * The server environment, sandbox or production, in which the App Store generated the response.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
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
     * The unique identifier of an app in the App Store.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/appappleid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * An array of information for auto-renewable subscriptions, including App Store-signed transaction information and
     * App Store-signed renewal information.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
     *
     * @return SubscriptionGroupIdentifierItem[]|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    public static function fromObject(stdClass $obj): StatusResponse
    {
        return new StatusResponse(
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            data: property_exists($obj, "data") && is_array($obj->data)
                ? array_map(
                    fn ($subscriptionGroupIdentifierItem)
                        => SubscriptionGroupIdentifierItem::fromObject((object)$subscriptionGroupIdentifierItem),
                    array_filter($obj->data, fn($subscriptionGroupIdentifierItem)
                        => $subscriptionGroupIdentifierItem instanceof stdClass
                            || is_array($subscriptionGroupIdentifierItem))
                ) : null
        );
    }
}
