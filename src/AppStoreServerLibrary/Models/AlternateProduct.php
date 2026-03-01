<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * A switch-plan message and product ID you provide in a real-time response to your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/alternateproduct
 */
class AlternateProduct implements JsonSerializable
{
    public function __construct(
        private readonly ?string $messageIdentifier,
        private readonly ?string $productId,
    ) {
    }

    /**
     * The message identifier of the text to display in the switch-plan retention message.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageidentifier
     */
    public function getMessageIdentifier(): ?string
    {
        return $this->messageIdentifier;
    }

    /**
     * The product identifier of the subscription the retention message suggests for your customer to switch to.
     *
     * https://developer.apple.com/documentation/retentionmessaging/productid
     */
    public function getProductId(): ?string
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
                $array[$key] = $value instanceof JsonSerializable ? $value->jsonSerialize() : $value;
            }
        }

        return $array;
    }
}
