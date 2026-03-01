<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body that contains the default configuration information.
 *
 * https://developer.apple.com/documentation/retentionmessaging/defaultconfigurationrequest
 */
class DefaultConfigurationRequest implements JsonSerializable
{
    public function __construct(
        private readonly string $messageIdentifier,
    ) {
    }

    /**
     * The message identifier of the message to configure as a default message.
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
