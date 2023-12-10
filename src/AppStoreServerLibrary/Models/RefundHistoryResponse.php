<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains an array of signed JSON Web Signature (JWS) refunded transactions, and paging information.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/refundhistoryresponse
 */
class RefundHistoryResponse
{
    /**
     * @param string[]|null $signedTransactions
     */
    public function __construct(
        private readonly ?array $signedTransactions,
        private readonly ?string $revision,
        private readonly ?bool $hasMore,
    ) {
    }

    /**
     * A list of up to 20 JWS transactions, or an empty array if the customer hasn't received any refunds in your app.
     * The transactions are sorted in ascending order by revocationDate.
     *
     * @return string[]|null
     */
    public function getSignedTransactions(): ?array
    {
        return $this->signedTransactions;
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

    public static function fromObject(stdClass $obj): RefundHistoryResponse
    {
        return new RefundHistoryResponse(
            signedTransactions: property_exists($obj, "signedTransactions") && is_array($obj->signedTransactions)
                ? array_filter(
                    $obj->signedTransactions,
                    fn($signedTransaction) => is_string($signedTransaction)
                ) : null,
            revision: property_exists($obj, "revision") && is_string($obj->revision)
                ? $obj->revision : null,
            hasMore: property_exists($obj, "hasMore") && is_bool($obj->hasMore)
                ? $obj->hasMore : null
        );
    }
}
