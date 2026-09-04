<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body for configuring the URL of your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/realtimeurlrequest
 */
class RealtimeUrlRequest implements JsonSerializable
{
    public function __construct(
        private readonly string $realtimeURL,
    ) {
    }

    /**
     * A string that contains the URL of your Get Retention Message endpoint for configuration.
     *
     * https://developer.apple.com/documentation/retentionmessaging/realtimeurl
     */
    public function getRealtimeURL(): string
    {
        return $this->realtimeURL;
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
