<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request object you provide for a performance test that contains an original transaction identifier.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performancetestrequest
 */
class PerformanceTestRequest implements JsonSerializable
{
    public function __construct(
        private readonly string $originalTransactionId,
    ) {
    }

    /**
     * The original transaction identifier of an In-App Purchase you initiate in the sandbox environment, to use as the
     * purchase for this test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/originaltransactionid
     */
    public function getOriginalTransactionId(): string
    {
        return $this->originalTransactionId;
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
