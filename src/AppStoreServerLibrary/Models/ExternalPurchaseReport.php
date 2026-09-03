<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The contents of an external purchase report for a single token.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/externalpurchasereport
 */
class ExternalPurchaseReport implements JsonSerializable
{
    /**
     * @param array<OneTimeBuyLineItem|RefundLineItem|SubscriptionBuyLineItem>|null $lineItems
     */
    public function __construct(
        private readonly string $requestIdentifier,
        private readonly string $externalPurchaseId,
        private readonly ExternalPurchaseStatus $status,
        private readonly ?array $lineItems,
    ) {
    }

    /**
     * A UUID that you generate to uniquely identify the report.
     */
    public function getRequestIdentifier(): string
    {
        return $this->requestIdentifier;
    }

    /**
     * The unique identifier of the external purchase token for which you submit the report.
     */
    public function getExternalPurchaseId(): string
    {
        return $this->externalPurchaseId;
    }

    /**
     * The status of the token that determines the information the report contains.
     */
    public function getStatus(): ExternalPurchaseStatus
    {
        return $this->status;
    }
        
    /**
     * An array of line items that describe transactions or events associated with the token identified by the
     * externalPurchaseId.
     *
     * @return array<OneTimeBuyLineItem|RefundLineItem|SubscriptionBuyLineItem>|null
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems;
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
