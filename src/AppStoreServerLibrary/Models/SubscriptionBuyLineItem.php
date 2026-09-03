<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;
use stdClass;
use ValueError;

/**
 * The line item that indicates a one-time charge transaction.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptionbuylineitem
 */
class SubscriptionBuyLineItem implements JsonSerializable
{
    public function __construct(
        private readonly ?string $lineItemId,
        private readonly ?string $referenceLineItemId,
        private readonly ?int $creationDate,
        private readonly ?SubscriptionEvent $subscriptionEvent,
        private readonly ?int $subscriptionStartDate,
        private readonly ?int $subscriptionEndDate,
        private readonly ?int $subscriptionDaysOfPaidService,
        private readonly ?string $pricingCurrency,
        private readonly ?string $reportingCurrency,
        private readonly ?int $amountTaxExclusive,
        private readonly ?int $amountTaxInclusive,
        private readonly ?int $netAmountTaxExclusive,
        private readonly ?int $taxAmount,
        private readonly ?string $taxCountry,
        private readonly ?string $productIdentifier,
        private readonly ?int $quantity,
        private readonly ?float $exchangeRate = null,
        private readonly bool $restatement = false,
        private readonly bool $erroneouslySubmitted = false,
        private readonly string $eventType = 'BUY',
        private readonly string $productType = 'SUBSCRIPTION',
    ) {
        if ($eventType !== 'BUY') {
            throw new ValueError('eventType must be "BUY"');
        }
        if ($productType !== 'SUBSCRIPTION') {
            throw new ValueError('productType must be "SUBSCRIPTION"');
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
     * The lineItemId of initial purchase transaction for the subscription.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/referencelineitemid
     */
    public function getReferenceLineItemId(): ?string
    {
        return $this->referenceLineItemId;
    }

    /**
     * The UNIX date, in milliseconds, that the customer authorized the purchase.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/creationdate
     */
    public function getCreationDate(): ?int
    {
        return $this->creationDate;
    }

    /**
     * The event in the subscription’s life cycle that the transaction represents.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptionevent
     */
    public function getSubscriptionEvent(): ?SubscriptionEvent
    {
        return $this->subscriptionEvent;
    }

    /**
     * The UNIX date, in milliseconds, of the start of the subscription renewal period.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptionstartdate
     */
    public function getSubscriptionStartDate(): ?int
    {
        return $this->subscriptionStartDate;
    }

    /**
     * The UNIX date, in milliseconds, of the end of the subscription renewal period.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptionenddate
     */
    public function getSubscriptionEndDate(): ?int
    {
        return $this->subscriptionEndDate;
    }

    /**
     * The total number of days of paid service for the subscription.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptiondaysofpaidservice
     */
    public function getSubscriptionDaysOfPaidService(): ?int
    {
        return $this->subscriptionDaysOfPaidService;
    }

    /**
     * The currency the transaction used to charge the customer.
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
     * A string that uniquely identifies the product.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/productidentifier
     */
    public function getProductIdentifier(): ?string
    {
        return $this->productIdentifier;
    }

    /**
     * The quantity of the product the customer purchased.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/quantity
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
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
     * Set to true to indicate that this line item is correcting (restating) a line item that you previously submitted.
     * For more information, see Reporting corrections. Default: false
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
     * Must be BUY.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/eventtype
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * Must be SUBSCRIPTION.
     *
     * https://developer.apple.com/documentation/externalpurchaseserverapi/producttype
     */
    public function getProductType(): string
    {
        return $this->productType;
    }

    public static function fromObject(stdClass $obj): SubscriptionBuyLineItem
    {
        return new SubscriptionBuyLineItem(
            lineItemId: property_exists($obj, "lineItemId")
                && is_string($obj->lineItemId)
                ? $obj->lineItemId : null,
            referenceLineItemId: property_exists($obj, "referenceLineItemId")
                && is_string($obj->referenceLineItemId)
                ? $obj->referenceLineItemId : null,
            creationDate: property_exists($obj, "creationDate")
                && is_int($obj->creationDate)
                ? $obj->creationDate : null,
            subscriptionEvent: property_exists($obj, "subscriptionEvent") && is_string($obj->subscriptionEvent)
                ? SubscriptionEvent::tryFrom($obj->subscriptionEvent) : null,
            subscriptionStartDate: property_exists($obj, "subscriptionStartDate")
                && is_int($obj->subscriptionStartDate)
                ? $obj->subscriptionStartDate : null,
            subscriptionEndDate: property_exists($obj, "subscriptionEndDate")
                && is_int($obj->subscriptionEndDate)
                ? $obj->subscriptionEndDate : null,
            subscriptionDaysOfPaidService: property_exists($obj, "subscriptionDaysOfPaidService")
                && is_int($obj->subscriptionDaysOfPaidService)
                ? $obj->subscriptionDaysOfPaidService : null,
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
            productIdentifier: property_exists($obj, "productIdentifier")
                && is_string($obj->productIdentifier)
                ? $obj->productIdentifier : null,
            quantity: property_exists($obj, "quantity")
                && is_int($obj->quantity)
                ? $obj->quantity : null,
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
            productType: property_exists($obj, "productType")
                && is_string($obj->productType)
                ? $obj->productType : 'ONE_TIME_BUY',
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
