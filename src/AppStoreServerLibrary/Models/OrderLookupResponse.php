<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

class OrderLookupResponse
{
    /**
     * @param string[]|null $signedTransactions
     */
    public function __construct(
        private readonly ?OrderLookupStatus $status,
        private readonly ?array $signedTransactions,
    ) {
    }

    /**
     * The status that indicates whether the order ID is valid.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/orderlookupstatus
     */
    public function getStatus(): ?OrderLookupStatus
    {
        return $this->status;
    }

    /**
     * An array of in-app purchase transactions that are part of order, signed by Apple, in JSON Web Signature format.
     *
     * @return string[]|null
     */
    public function getSignedTransactions(): ?array
    {
        return $this->signedTransactions;
    }

    public static function fromObject(stdClass $obj): OrderLookupResponse
    {
        return new OrderLookupResponse(
            status: property_exists($obj, "status") && is_int($obj->status)
                ? OrderLookupStatus::tryFrom($obj->status) : null,
            signedTransactions: property_exists($obj, "signedTransactions") && is_array($obj->signedTransactions)
                ? array_filter(
                    $obj->signedTransactions,
                    fn($signedTransaction) => is_string($signedTransaction)
                ) : null
        );
    }
}
