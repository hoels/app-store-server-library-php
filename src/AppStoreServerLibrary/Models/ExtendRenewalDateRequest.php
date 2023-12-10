<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body that contains subscription-renewal-extension data for an individual subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/extendrenewaldaterequest
 */
class ExtendRenewalDateRequest implements JsonSerializable
{
    public function __construct(
        private readonly int $extendByDays,
        private readonly ExtendReasonCode $extendReasonCode,
        private readonly string $requestIdentifier,
    ) {
    }

    /**
     * The number of days to extend the subscription renewal date.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/extendbydays
     * maximum: 90
     */
    public function getExtendByDays(): int
    {
        return $this->extendByDays;
    }

    /**
     * The reason code for the subscription date extension
     *
     * https://developer.apple.com/documentation/appstoreserverapi/extendreasoncode
     */
    public function getExtendReasonCode(): ExtendReasonCode
    {
        return $this->extendReasonCode;
    }

    /**
     * A string that contains a unique identifier you provide to track each subscription-renewal-date extension request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public function getRequestIdentifier(): string
    {
        return $this->requestIdentifier;
    }

    /**
     * @return array<string, int|int[]|string|string[]|boolean|boolean[]|null>
     */
    public function jsonSerialize(): array
    {
        $array = [];
        /**
         * @var string $key
         * @var int|int[]|string|string[]|boolean|boolean[]|null $value
         */
        foreach ($this as $key => $value) {
            if ($value !== null) {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
