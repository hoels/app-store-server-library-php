<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that indicates the current status of a request to extend the subscription renewal date to all eligible
 * subscribers.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldatestatusresponse
 */
class MassExtendRenewalDateStatusResponse
{
    public function __construct(
        private readonly ?string $requestIdentifier,
        private readonly ?bool $complete,
        private readonly ?int $completeDate,
        private readonly ?int $succeededCount,
        private readonly ?int $failedCount,
    ) {
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
     * A Boolean value that indicates whether the App Store completed the request to extend a subscription renewal date
     * to active subscribers.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/complete
     */
    public function getComplete(): ?bool
    {
        return $this->complete;
    }

    /**
     * The UNIX time, in milliseconds, that the App Store completes a request to extend a subscription renewal date for
     * eligible subscribers.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/completedate
     */
    public function getCompleteDate(): ?int
    {
        return $this->completeDate;
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

    public static function fromObject(stdClass $obj): MassExtendRenewalDateStatusResponse
    {
        return new MassExtendRenewalDateStatusResponse(
            requestIdentifier: property_exists($obj, "requestIdentifier") && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null,
            complete: property_exists($obj, "complete") && is_bool($obj->complete)
                ? $obj->complete : null,
            completeDate: property_exists($obj, "completeDate")
                && (is_int($obj->completeDate) || is_float($obj->completeDate))
                ? intval($obj->completeDate) : null,
            succeededCount: property_exists($obj, "succeededCount") && is_int($obj->succeededCount)
                ? $obj->succeededCount : null,
            failedCount: property_exists($obj, "failedCount") && is_int($obj->failedCount)
                ? $obj->failedCount : null,
        );
    }
}
