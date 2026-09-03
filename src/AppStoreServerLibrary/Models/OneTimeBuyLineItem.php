<?php

namespace AppStoreServerLibrary\Models;

use AppStoreServerLibrary\Models\ExternalPurchaseReport\EventType;
use AppStoreServerLibrary\Models\ExternalPurchaseReport\ProductType;
use JsonSerializable;

/**
 * The line item that indicates a one-time charge transaction.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/onetimebuylineitem
 */
class OneTimeBuyLineItem implements JsonSerializable
{
    private readonly EventType $eventType;
    private readonly ProductType $productType;
    
    public function __construct(
        private readonly string $lineItemId,
        private readonly int $creationDate,
        private readonly string $pricingCurrency,
        private readonly string $reportingCurrency,
        private readonly int $amountTaxExclusive,
        private readonly int $amountTaxInclusive,
        private readonly int $netAmountTaxExclusive,
        private readonly int $taxAmount,
        private readonly string $taxCountry,
        private readonly string $productIdentifier,
        private readonly int $quantity,
        private readonly bool $restatement = false,
        private readonly bool $erroneouslySubmitted = false,
        private readonly ?float $exchangeRate = null,
    ) {
        $this->eventType = EventType::BUY;
        $this->productType = ProductType::ONE_TIME_BUY;
    }

    /**
     * A unique identifier for the transaction, that you determine. The value must be unique per app. Using UUIDs is
     * recommended. Reuse a lineItemId only to submit a restatement for a previously submitted line item.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/lineitemid
     */
    public function getLineItemId(): string
    {
        return $this->lineItemId;
    }

    /**
     * The UNIX date, in milliseconds, that the customer authorized the purchase.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/creationdate
     */
    public function getCreationDate(): int
    {
        return $this->creationDate;
    }

    /**
     * Set to true to indicate that this line item is correcting (restating) a line item that you previously submitted.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/restatement
     */
    public function getRestatement(): bool
    {
        return $this->restatement;
    }

    /**
     * Set to true to indicate that you previously submitted the line item erroneously. Set the restatement field to
     * true also.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/erroneouslysubmitted
     */
    public function getErroneouslySubmitted(): bool
    {
        return $this->erroneouslySubmitted;
    }

    /**
     * The currency the transaction used to charge the customer.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/pricingcurrency
     */
    public function getPricingCurrency(): string
    {
        return $this->pricingCurrency;
    }

    /**
     * The currency you use to report all the amount fields, including amountTaxExclusive, amountTaxInclusive,
     * netAmountTaxExclusive, and taxAmount.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/reportingcurrency
     */
    public function getReportingCurrency(): string
    {
        return $this->reportingCurrency;
    }

    /**
     * The exchange rate you use to calculate the amounts, from the pricing currency to the reporting currency, if the
     * customer is billed in an unsupported currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/exchangerate
     */
    public function getExchangeRate(): ?float
    {
        return $this->exchangeRate;
    }

    /**
     * The amount that the customer paid, excluding taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/amounttaxexclusive
     */
    public function getAmountTaxExclusive(): int
    {
        return $this->amountTaxExclusive;
    }

    /**
     * The amount that the customer paid, including taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/amounttaxinclusive
     */
    public function getAmountTaxInclusive(): int
    {
        return $this->amountTaxInclusive;
    }

    /**
     * The net amount the customer was charged, accurate to the current report, that you state in milli-units of the
     * reporting currency. This amount excludes tax, and accounts for all refunds and restatements.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/netamounttaxexclusive
     */
    public function getNetAmountTaxExclusive(): int
    {
        return $this->netAmountTaxExclusive;
    }

    /**
     * The amount the customer paid in taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/taxamount
     */
    public function getTaxAmount(): int
    {
        return $this->taxAmount;
    }

    /**
     * The country code of the country for which taxes were paid on the purchase.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/taxcountry
     */
    public function getTaxCountry(): string
    {
        return $this->taxCountry;
    }

    /**
     * A string that uniquely identifies the product.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/productidentifier
     */
    public function getProductIdentifier(): string
    {
        return $this->productIdentifier;
    }

    /**
     * The quantity of the product the customer purchased.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/quantity
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * Always BUY.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/eventtype
     */
    public function getEventType(): EventType
    {
        return $this->eventType;
    }

    /**
     * Always ONE_TIME_BUY.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/producttype
     */
    public function getProductType(): ProductType
    {
        return $this->productType;
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
