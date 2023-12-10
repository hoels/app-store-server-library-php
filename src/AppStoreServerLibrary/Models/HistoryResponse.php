<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains the customer's transaction history for an app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/historyresponse
 */
class HistoryResponse
{
    /**
     * @param string[]|null $signedTransactions
     */
    public function __construct(
        private readonly ?string $revision,
        private readonly ?bool $hasMore,
        private readonly ?string $bundleId,
        private readonly ?int $appAppleId,
        private readonly ?Environment $environment,
        private readonly ?array $signedTransactions,
    ) {
    }

    /**
     * A token you use in a query to request the next set of transactions for the customer.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/revision
     */
    public function getRevision(): ?string
    {
        return $this->revision;
    }

    /**
     * A Boolean value indicating whether the App Store has more transaction data.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/hasmore
     */
    public function getHasMore(): ?bool
    {
        return $this->hasMore;
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
     * The server environment in which you're making the request, whether sandbox or production.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    /**
     * An array of in-app purchase transactions for the customer, signed by Apple, in JSON Web Signature format.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     *
     * @return string[]|null
     */
    public function getSignedTransactions(): ?array
    {
        return $this->signedTransactions;
    }

    public static function fromObject(stdClass $obj): HistoryResponse
    {
        return new HistoryResponse(
            revision: property_exists($obj, "revision") && is_string($obj->revision)
                ? $obj->revision : null,
            hasMore: property_exists($obj, "hasMore") && is_bool($obj->hasMore)
                ? $obj->hasMore : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            signedTransactions: property_exists($obj, "signedTransactions") && is_array($obj->signedTransactions)
                ? array_filter(
                    $obj->signedTransactions,
                    fn($signedTransaction) => is_string($signedTransaction)
                ) : null,
        );
    }
}
