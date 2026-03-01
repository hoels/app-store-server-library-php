<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * A response you provide to choose, in real time, a retention message the system displays to the customer.
 *
 * https://developer.apple.com/documentation/retentionmessaging/realtimeresponsebody
 */
class RealtimeResponseBody implements JsonSerializable
{
    public function __construct(
        private readonly ?Message $message,
        private readonly ?AlternateProduct $alternateProduct,
        private readonly ?PromotionalOffer $promotionalOffer,
    ) {
    }

    /**
     * A retention message that's text-based and can include an optional image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/message
     */
    public function getMessage(): ?Message
    {
        return $this->message;
    }

    /**
     * A retention message with a switch-plan option.
     *
     * https://developer.apple.com/documentation/retentionmessaging/alternateproduct
     */
    public function getAlternateProduct(): ?AlternateProduct
    {
        return $this->alternateProduct;
    }

    /**
     * A retention message that includes a promotional offer.
     *
     * https://developer.apple.com/documentation/retentionmessaging/promotionaloffer
     */
    public function getPromotionalOffer(): ?PromotionalOffer
    {
        return $this->promotionalOffer;
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
