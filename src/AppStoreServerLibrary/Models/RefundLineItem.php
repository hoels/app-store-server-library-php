<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;
use stdClass;
use ValueError;

/**
 * The line item that indicates a refund transaction.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/refundlineitem
 */
class RefundLineItem implements JsonSerializable
{
    public function __construct(
        private readonly ?string $lineItemId,
        private readonly ?string $referenceLineItemId,
        private readonly ?int $creationDate,
        private readonly ?string $pricingCurrency,
        private readonly ?string $reportingCurrency,
        private readonly ?int $amountTaxExclusive,
        private readonly ?int $amountTaxInclusive,
        private readonly ?int $netAmountTaxExclusive,
        private readonly ?int $taxAmount,
        private readonly ?string $taxCountry,
        private readonly ?float $exchangeRate = null,
        private readonly bool $restatement = false,
        private readonly bool $erroneouslySubmitted = false,
        private readonly string $eventType = 'REFUND',
    ) {
        if ($eventType !== 'REFUND') {
            throw new ValueError('eventType must be "REFUND"');
        }
    }

    /**
     * A unique identifier for the transaction, that you determine. The value must be unique per app. Using UUIDs is
     * recommended. Reuse a lineItemId only to submit a restatement for a previously submitted line item.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/lineitemid
     */
    public function getLineItemId(): ?string
    {
        return $this->lineItemId;
    }

    /**
     * The lineItemId of the initial purchase transaction that receives a refund.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/referencelineitemid
     */
    public function getReferenceLineItemId(): ?string
    {
        return $this->referenceLineItemId;
    }

    /**
     * The UNIX date, in milliseconds, you completed the transaction.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/creationdate
     */
    public function getCreationDate(): ?int
    {
        return $this->creationDate;
    }

    /**
     * The currency the transaction used to charge or refund the customer.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/pricingcurrency
     */
    public function getPricingCurrency(): ?string
    {
        return $this->pricingCurrency;
    }

    /**
     * The currency you use to report all the amount fields, including amountTaxExclusive, amountTaxInclusive,
     * netAmountTaxExclusive, and taxAmount.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/reportingcurrency
     */
    public function getReportingCurrency(): ?string
    {
        return $this->reportingCurrency;
    }

    /**
     * The amount that the customer paid, excluding taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/amounttaxexclusive
     */
    public function getAmountTaxExclusive(): ?int
    {
        return $this->amountTaxExclusive;
    }

    /**
     * The amount that the customer paid, including taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/amounttaxinclusive
     */
    public function getAmountTaxInclusive(): ?int
    {
        return $this->amountTaxInclusive;
    }

    /**
     * The net amount the customer was charged, accurate to the current report, that you state in milli-units of the
     * reporting currency. This amount excludes tax, and accounts for all refunds and restatements.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/netamounttaxexclusive
     */
    public function getNetAmountTaxExclusive(): ?int
    {
        return $this->netAmountTaxExclusive;
    }

    /**
     * The amount the customer paid in taxes, that you state in milli-units of the reporting currency.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/taxamount
     */
    public function getTaxAmount(): ?int
    {
        return $this->taxAmount;
    }

    /**
     * The country code of the country for which taxes were paid on the purchase.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/taxcountry
     */
    public function getTaxCountry(): ?string
    {
        return $this->taxCountry;
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
     * Set to true to indicate that this line item is correcting (restating) a refund line item that you previously
     * submitted. For more information, see Reporting corrections. Default: false
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/restatement
     */
    public function getRestatement(): bool
    {
        return $this->restatement;
    }

    /**
     * Set to true to indicate that you previously submitted the line item erroneously. Set the restatement field to
     * true also. For more information, see Reporting corrections. Default: false
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/erroneouslysubmitted
     */
    public function getErroneouslySubmitted(): bool
    {
        return $this->erroneouslySubmitted;
    }

    /**
     * Must be REFUND.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/eventtype
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    public static function fromObject(stdClass $obj): RefundLineItem
    {
        return new RefundLineItem(
            lineItemId: property_exists($obj, "lineItemId")
                && is_string($obj->lineItemId)
                ? $obj->lineItemId : null,
            referenceLineItemId: property_exists($obj, "referenceLineItemId")
                && is_string($obj->referenceLineItemId)
                ? $obj->referenceLineItemId : null,
            creationDate: property_exists($obj, "creationDate")
                && is_int($obj->creationDate)
                ? $obj->creationDate : null,
            pricingCurrency: property_exists($obj, "pricingCurrency")
                && is_string($obj->pricingCurrency)
                ? $obj->pricingCurrency : null,
            reportingCurrency: property_exists($obj, "reportingCurrency")
                && is_string($obj->reportingCurrency)
                ? $obj->reportingCurrency : null,
            amountTaxExclusive: property_exists($obj, "amountTaxExclusive")
                && is_int($obj->amountTaxExclusive)
                ? $obj->amountTaxExclusive : null,
            amountTaxInclusive: property_exists($obj, "amountTaxInclusive")
                && is_int($obj->amountTaxInclusive)
                ? $obj->amountTaxInclusive : null,
            netAmountTaxExclusive: property_exists($obj, "netAmountTaxExclusive")
                && is_int($obj->netAmountTaxExclusive)
                ? $obj->netAmountTaxExclusive : null,
            taxAmount: property_exists($obj, "taxAmount")
                && is_int($obj->taxAmount)
                ? $obj->taxAmount : null,
            taxCountry: property_exists($obj, "taxCountry")
                && is_string($obj->taxCountry)
                ? $obj->taxCountry : null,
            exchangeRate: property_exists($obj, "exchangeRate")
                && is_float($obj->exchangeRate)
                ? $obj->exchangeRate : null,
            restatement: property_exists($obj, "restatement")
                && is_bool($obj->restatement)
                ? $obj->restatement : false,
            erroneouslySubmitted: property_exists($obj, "erroneouslySubmitted")
                && is_bool($obj->erroneouslySubmitted)
                ? $obj->erroneouslySubmitted : false,
            eventType: property_exists($obj, "eventType")
                && is_string($obj->eventType)
                ? $obj->eventType : 'BUY',
        );
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
