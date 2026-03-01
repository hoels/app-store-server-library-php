<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * A message identifier you provide in a real-time response to your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/message
 */
class Message implements JsonSerializable
{
    public function __construct(
        private readonly string $messageIdentifier,
    ) {
    }

    /**
     * The identifier of the message to display to the customer.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageidentifier
     */
    public function getMessageIdentifier(): string
    {
        return $this->messageIdentifier;
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
