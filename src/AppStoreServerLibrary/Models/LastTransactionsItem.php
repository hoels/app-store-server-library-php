<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The most recent App Store-signed transaction information and App Store-signed renewal information for an
 * auto-renewable subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/lasttransactionsitem
 */
class LastTransactionsItem
{
    public function __construct(
        private readonly ?Status $status,
        private readonly ?string $originalTransactionId,
        private readonly ?string $signedTransactionInfo,
        private readonly ?string $signedRenewalInfo,
    ) {
    }

    /**
     * The status of the auto-renewable subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/status
     */
    public function getStatus(): ?Status
    {
        return $this->status;
    }

    /**
     * The original transaction identifier of a purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public function getOriginalTransactionId(): ?string
    {
        return $this->originalTransactionId;
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

    public static function fromObject(stdClass $obj): LastTransactionsItem
    {
        return new LastTransactionsItem(
            status: property_exists($obj, "status") && is_int($obj->status)
                ? Status::tryFrom($obj->status) : null,
            originalTransactionId: property_exists($obj, "originalTransactionId")
                && is_string($obj->originalTransactionId)
                ? $obj->originalTransactionId : null,
            signedTransactionInfo: property_exists($obj, "signedTransactionInfo")
                && is_string($obj->signedTransactionInfo)
                ? $obj->signedTransactionInfo : null,
            signedRenewalInfo: property_exists($obj, "signedRenewalInfo") && is_string($obj->signedRenewalInfo)
                ? $obj->signedRenewalInfo : null
        );
    }
}
