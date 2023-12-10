<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * Information for auto-renewable subscriptions, including signed transaction information and signed renewal
 * information, for one subscription group.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifieritem
 */
class SubscriptionGroupIdentifierItem
{
    /**
     * @param LastTransactionsItem[]|null $lastTransactions
     */
    public function __construct(
        private readonly ?string $subscriptionGroupIdentifier,
        private readonly ?array $lastTransactions,
    ) {
    }

    /**
     * The identifier of the subscription group that the subscription belongs to.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     */
    public function getSubscriptionGroupIdentifier(): ?string
    {
        return $this->subscriptionGroupIdentifier;
    }

    /**
     * An array of the most recent App Store-signed transaction information and App Store-signed renewal information for
     * all auto-renewable subscriptions in the subscription group.
     *
     * @return LastTransactionsItem[]|null
     */
    public function getLastTransactions(): ?array
    {
        return $this->lastTransactions;
    }

    public static function fromObject(stdClass $obj): SubscriptionGroupIdentifierItem
    {
        return new SubscriptionGroupIdentifierItem(
            subscriptionGroupIdentifier: property_exists($obj, "subscriptionGroupIdentifier")
                && is_string($obj->subscriptionGroupIdentifier)
                ? $obj->subscriptionGroupIdentifier : null,
            lastTransactions: property_exists($obj, "lastTransactions") && is_array($obj->lastTransactions)
                ? array_map(
                    fn ($lastTransactionsItem) => LastTransactionsItem::fromObject((object)$lastTransactionsItem),
                    array_filter($obj->lastTransactions, fn($lastTransactionsItem)
                        => $lastTransactionsItem instanceof stdClass || is_array($lastTransactionsItem))
                ) : null
        );
    }
}
