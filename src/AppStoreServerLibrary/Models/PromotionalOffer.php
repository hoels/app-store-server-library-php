<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * A promotional offer and message you provide in a real-time response to your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/promotionaloffer
 */
class PromotionalOffer implements JsonSerializable
{
    public function __construct(
        private readonly ?string $messageIdentifier,
        private readonly ?string $promotionalOfferSignatureV2,
        private readonly ?PromotionalOfferSignatureV1 $promotionalOfferSignatureV1,
    ) {
    }

    /**
     * The identifier of the message to display to the customer, along with the promotional offer.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageidentifier
     */
    public function getMessageIdentifier(): ?string
    {
        return $this->messageIdentifier;
    }

    /**
     * The promotional offer signature in V2 format.
     *
     * https://developer.apple.com/documentation/retentionmessaging/promotionaloffersignaturev2
     */
    public function getPromotionalOfferSignatureV2(): ?string
    {
        return $this->promotionalOfferSignatureV2;
    }

    /**
     * The promotional offer signature in V1 format.
     *
     * https://developer.apple.com/documentation/retentionmessaging/promotionaloffersignaturev1
     */
    public function getPromotionalOfferSignatureV1(): ?PromotionalOfferSignatureV1
    {
        return $this->promotionalOfferSignatureV1;
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
                $array[$key] = $value instanceof JsonSerializable ? $value->jsonSerialize() : $value;
            }
        }

        return $array;
    }
}
