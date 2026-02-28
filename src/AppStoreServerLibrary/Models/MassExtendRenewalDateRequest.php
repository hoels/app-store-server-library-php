<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body that contains subscription-renewal-extension data to apply for all eligible active subscribers.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldaterequest
 */
class MassExtendRenewalDateRequest implements JsonSerializable
{
    /**
     * @param string[]|null $storefrontCountryCodes
     */
    public function __construct(
        private readonly int $extendByDays,
        private readonly ExtendReasonCode $extendReasonCode,
        private readonly string $requestIdentifier,
        private readonly ?array $storefrontCountryCodes,
        private readonly string $productId,
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
     * The reason code for the subscription-renewal-date extension.
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
     * A list of storefront country codes you provide to limit the storefronts for a subscription-renewal-date
     * extension.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/storefrontcountrycodes
     *
     * @return string[]|null
     */
    public function getStorefrontCountryCodes(): ?array
    {
        return $this->storefrontCountryCodes;
    }

    /**
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public function getProductId(): string
    {
        return $this->productId;
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
         * @phpstan-ignore foreach.nonIterable
         */
        foreach ($this as $key => $value) {
            if ($value !== null) {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
