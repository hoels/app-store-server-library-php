<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that indicates whether an individual renewal-date extension succeeded, and related details.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldateresponse
 */
class ExtendRenewalDateResponse
{
    public function __construct(
        private readonly ?string $originalTransactionId,
        private readonly ?string $webOrderLineItemId,
        private readonly ?bool $success,
        private readonly ?int $effectiveDate,
    ) {
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
     * The unique identifier of subscription-purchase events across devices, including renewals.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/weborderlineitemid
     */
    public function getWebOrderLineItemId(): ?string
    {
        return $this->webOrderLineItemId;
    }

    /**
     * A Boolean value that indicates whether the subscription-renewal-date extension succeeded.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/success
     */
    public function getSuccess(): ?bool
    {
        return $this->success;
    }

    /**
     * The new subscription expiration date for a subscription-renewal extension.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/effectivedate
     */
    public function getEffectiveDate(): ?int
    {
        return $this->effectiveDate;
    }

    public static function fromObject(stdClass $obj): ExtendRenewalDateResponse
    {
        return new ExtendRenewalDateResponse(
            originalTransactionId: property_exists($obj, "originalTransactionId")
                && is_string($obj->originalTransactionId)
                ? $obj->originalTransactionId : null,
            webOrderLineItemId: property_exists($obj, "webOrderLineItemId") && is_string($obj->webOrderLineItemId)
                ? $obj->webOrderLineItemId : null,
            success: property_exists($obj, "success") && is_bool($obj->success)
                ? $obj->success : null,
            effectiveDate: property_exists($obj, "effectiveDate")
                && (is_int($obj->effectiveDate) || is_float($obj->effectiveDate))
                ? intval($obj->effectiveDate) : null
        );
    }
}
