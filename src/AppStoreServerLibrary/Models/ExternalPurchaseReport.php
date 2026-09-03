<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;
use stdClass;
use ValueError;

/**
 * The contents of an external purchase report for a single token.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/externalpurchasereport
 */
class ExternalPurchaseReport implements JsonSerializable
{
    /**
     * @param (OneTimeBuyLineItem|RefundLineItem|SubscriptionBuyLineItem)[]|null $lineItems
     */
    public function __construct(
        private readonly ?string $requestIdentifier,
        private readonly ?string $externalPurchaseId,
        private readonly ?ExternalPurchaseStatus $status,
        private readonly ?array $lineItems,
    ) {
    }

    /**
     * A UUID that you generate to uniquely identify the report.
     */
    public function getRequestIdentifier(): ?string
    {
        return $this->requestIdentifier;
    }

    /**
     * The unique identifier of the external purchase token for which you submit the report.
     */
    public function getExternalPurchaseId(): ?string
    {
        return $this->externalPurchaseId;
    }

    /**
     * The status of the token that determines the information the report contains.
     */
    public function getStatus(): ?ExternalPurchaseStatus
    {
        return $this->status;
    }
        
    /**
     * An array of line items that describe transactions or events associated with the token identified by the
     * externalPurchaseId.
     *
     * @return (OneTimeBuyLineItem|RefundLineItem|SubscriptionBuyLineItem)[]|null
     */
    public function getLineItems(): ?array
    {
        return $this->lineItems;
    }

    public static function fromObject(stdClass $obj): ExternalPurchaseReport
    {
        return new ExternalPurchaseReport(
            requestIdentifier: property_exists($obj, "requestIdentifier") && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null,
            externalPurchaseId: property_exists($obj, "externalPurchaseId") && is_string($obj->externalPurchaseId)
                ? $obj->externalPurchaseId : null,
            status: property_exists($obj, "status") && is_string($obj->status)
                ? ExternalPurchaseStatus::tryFrom($obj->status) : null,
            lineItems: property_exists($obj, "lineItems") && is_array($obj->lineItems)
                ? array_map(
                    fn ($lineItem) => self::lineItem((object)$lineItem),
                    array_filter($obj->lineItems, fn($lineItem)
                    => $lineItem instanceof stdClass || is_array($lineItem))
                ) : null,
        );
    }

    private static function lineItem(stdClass $obj): OneTimeBuyLineItem|RefundLineItem|SubscriptionBuyLineItem
    {
        $eventType = property_exists($obj, "eventType")
                && is_string($obj->eventType)
                ?$obj->eventType : null;
        $productType = property_exists($obj, "productType")
                && is_string($obj->productType)
                ?$obj->productType : null;

        if ($eventType == 'REFUND') {
            return RefundLineItem::fromObject($obj);
        }
        if ($productType == 'ONE_TIME_BUY') {
            return OneTimeBuyLineItem::fromObject($obj);
        }
        if ($productType == 'SUBSCRIPTION') {
            return SubscriptionBuyLineItem::fromObject($obj);
        }

        throw new ValueError('Unknown eventType and productType');
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
