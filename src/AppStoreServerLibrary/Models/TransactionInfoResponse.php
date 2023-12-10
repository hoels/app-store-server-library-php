<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains signed transaction information for a single transaction.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/transactioninforesponse
 */
class TransactionInfoResponse
{
    public function __construct(
        private readonly ?string $signedTransactionInfo,
    ) {
    }

    /**
     * A customer’s in-app purchase transaction, signed by Apple, in JSON Web Signature (JWS) format.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/jwstransaction
     */
    public function getSignedTransactionInfo(): ?string
    {
        return $this->signedTransactionInfo;
    }

    public static function fromObject(stdClass $obj): TransactionInfoResponse
    {
        return new TransactionInfoResponse(
            signedTransactionInfo: property_exists($obj, "signedTransactionInfo")
                && is_string($obj->signedTransactionInfo)
                ? $obj->signedTransactionInfo : null
        );
    }
}
