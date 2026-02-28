<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A decoded payload containing subscription renewal information for an auto-renewable subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/jwsrenewalinfodecodedpayload
 */
class JWSRenewalInfoDecodedPayload
{
    /**
     * @param string[]|null $eligibleWinBackOfferIds
     */
    public function __construct(
        private readonly ?ExpirationIntent $expirationIntent,
        private readonly ?string $originalTransactionId,
        private readonly ?string $autoRenewProductId,
        private readonly ?string $productId,
        private readonly ?AutoRenewStatus $autoRenewStatus,
        private readonly ?bool $isInBillingRetryPeriod,
        private readonly ?PriceIncreaseStatus $priceIncreaseStatus,
        private readonly ?int $gracePeriodExpiresDate,
        private readonly ?OfferType $offerType,
        private readonly ?string $offerIdentifier,
        private readonly ?int $signedDate,
        private readonly ?Environment $environment,
        private readonly ?int $recentSubscriptionStartDate,
        private readonly ?int $renewalDate,
        private readonly ?string $currency,
        private readonly ?int $renewalPrice,
        private readonly ?OfferDiscountType $offerDiscountType,
        private readonly ?array $eligibleWinBackOfferIds,
        private readonly ?string $appAccountToken,
        private readonly ?string $appTransactionId,
        private readonly ?string $offerPeriod,
    ) {
    }
    
    /**
     * The reason the subscription expired.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/expirationintent
     */
    public function getExpirationIntent(): ?ExpirationIntent
    {
        return $this->expirationIntent;
    }

    /**
     * The original transaction identifier of a purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/originaltransactionid
     */
    public function getOriginalTransactionId(): ?string
    {
        return $this->originalTransactionId;
    }

    /**
     * The product identifier of the product that will renew at the next billing period.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/autorenewproductid
     */
    public function getAutoRenewProductId(): ?string
    {
        return $this->autoRenewProductId;
    }

    /**
     * The unique identifier for the product, that you create in App Store Connect.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/productid
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * The renewal status of the auto-renewable subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/autorenewstatus
     */
    public function getAutoRenewStatus(): ?AutoRenewStatus
    {
        return $this->autoRenewStatus;
    }

    /**
     * A Boolean value that indicates whether the App Store is attempting to automatically renew an expired
     * subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/isinbillingretryperiod
     */
    public function getIsInBillingRetryPeriod(): ?bool
    {
        return $this->isInBillingRetryPeriod;
    }

    /**
     * The status that indicates whether the auto-renewable subscription is subject to a price increase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/priceincreasestatus
     */
    public function getPriceIncreaseStatus(): ?PriceIncreaseStatus
    {
        return $this->priceIncreaseStatus;
    }

    /**
     * The time when the billing grace period for subscription renewals expires.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/graceperiodexpiresdate
     */
    public function getGracePeriodExpiresDate(): ?int
    {
        return $this->gracePeriodExpiresDate;
    }

    /**
     * The type of offer.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offertype
     */
    public function getOfferType(): ?OfferType
    {
        return $this->offerType;
    }

    /**
     * The offer code or the promotional offer identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offeridentifier
     */
    public function getOfferIdentifier(): ?string
    {
        return $this->offerIdentifier;
    }

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/signeddate
     */
    public function getSignedDate(): ?int
    {
        return $this->signedDate;
    }

    /**
     * The server environment, either sandbox or production.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    /**
     * The earliest start date of a subscription in a series of auto-renewable subscription purchases that ignores all
     * lapses of paid service shorter than 60 days.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/recentsubscriptionstartdate
     */
    public function getRecentSubscriptionStartDate(): ?int
    {
        return $this->recentSubscriptionStartDate;
    }

    /**
     * The UNIX time, in milliseconds, that the most recent auto-renewable subscription purchase expires.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/renewaldate
     */
    public function getRenewalDate(): ?int
    {
        return $this->renewalDate;
    }

    /**
     * The currency code for the renewalPrice of the subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * The renewal price, in milliunits, of the auto-renewable subscription that renews at the next billing period.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/renewalprice
     */
    public function getRenewalPrice(): ?int
    {
        return $this->renewalPrice;
    }

    /**
     * The payment mode you configure for the offer.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
     */
    public function getOfferDiscountType(): ?OfferDiscountType
    {
        return $this->offerDiscountType;
    }

    /**
     * An array of win-back offer identifiers that a customer is eligible to redeem, which sorts the identifiers to
     * present the better offers first.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/eligiblewinbackofferids
     *
     * @return string[]|null
     */
    public function getEligibleWinBackOfferIds(): ?array
    {
        return $this->eligibleWinBackOfferIds;
    }

    /**
     * The UUID that an app optionally generates to map a customer's in-app purchase with its resulting App Store
     * transaction.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/appaccounttoken
     */
    public function getAppAccountToken(): ?string
    {
        return $this->appAccountToken;
    }

    /**
     * The unique identifier of the app download transaction.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/appTransactionId
     */
    public function getAppTransactionId(): ?string
    {
        return $this->appTransactionId;
    }

    /**
     * The duration of the offer.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offerPeriod
     */
    public function getOfferPeriod(): ?string
    {
        return $this->offerPeriod;
    }

    public static function fromObject(stdClass $obj): JWSRenewalInfoDecodedPayload
    {
        return new JWSRenewalInfoDecodedPayload(
            expirationIntent: property_exists($obj, "expirationIntent") && is_int($obj->expirationIntent)
                ? ExpirationIntent::tryFrom($obj->expirationIntent) : null,
            originalTransactionId: property_exists($obj, "originalTransactionId")
                && is_string($obj->originalTransactionId)
                ? $obj->originalTransactionId : null,
            autoRenewProductId: property_exists($obj, "autoRenewProductId") && is_string($obj->autoRenewProductId)
                ? $obj->autoRenewProductId : null,
            productId: property_exists($obj, "productId") && is_string($obj->productId)
                ? $obj->productId : null,
            autoRenewStatus: property_exists($obj, "autoRenewStatus") && is_int($obj->autoRenewStatus)
                ? AutoRenewStatus::tryFrom($obj->autoRenewStatus) : null,
            isInBillingRetryPeriod: property_exists($obj, "isInBillingRetryPeriod")
                && is_bool($obj->isInBillingRetryPeriod)
                ? $obj->isInBillingRetryPeriod : null,
            priceIncreaseStatus: property_exists($obj, "priceIncreaseStatus") && is_int($obj->priceIncreaseStatus)
                ? PriceIncreaseStatus::tryFrom($obj->priceIncreaseStatus) : null,
            gracePeriodExpiresDate: property_exists($obj, "gracePeriodExpiresDate")
                && (is_int($obj->gracePeriodExpiresDate) || is_float($obj->gracePeriodExpiresDate))
                ? intval($obj->gracePeriodExpiresDate) : null,
            offerType: property_exists($obj, "offerType") && is_int($obj->offerType)
                ? OfferType::tryFrom($obj->offerType) : null,
            offerIdentifier: property_exists($obj, "offerIdentifier") && is_string($obj->offerIdentifier)
                ? $obj->offerIdentifier : null,
            signedDate: property_exists($obj, "signedDate")
                && (is_int($obj->signedDate) || is_float($obj->signedDate))
                ? intval($obj->signedDate) : null,
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            recentSubscriptionStartDate: property_exists($obj, "recentSubscriptionStartDate")
                && (is_int($obj->recentSubscriptionStartDate) || is_float($obj->recentSubscriptionStartDate))
                ? intval($obj->recentSubscriptionStartDate) : null,
            renewalDate: property_exists($obj, "renewalDate")
                && (is_int($obj->renewalDate) || is_float($obj->renewalDate))
                ? intval($obj->renewalDate) : null,
            currency: property_exists($obj, "currency") && is_string($obj->currency)
                ? $obj->currency : null,
            renewalPrice: property_exists($obj, "renewalPrice") && is_int($obj->renewalPrice)
                ? $obj->renewalPrice : null,
            offerDiscountType: property_exists($obj, "offerDiscountType") && is_string($obj->offerDiscountType)
                ? OfferDiscountType::tryFrom($obj->offerDiscountType) : null,
            eligibleWinBackOfferIds: property_exists($obj, "eligibleWinBackOfferIds")
                && is_array($obj->eligibleWinBackOfferIds)
                && array_is_list($obj->eligibleWinBackOfferIds)
                && array_filter($obj->eligibleWinBackOfferIds, "is_string") === $obj->eligibleWinBackOfferIds
                ? $obj->eligibleWinBackOfferIds : null,
            appAccountToken: property_exists($obj, "appAccountToken") && is_string($obj->appAccountToken)
                ? $obj->appAccountToken : null,
            appTransactionId: property_exists($obj, "appTransactionId") && is_string($obj->appTransactionId)
                ? $obj->appTransactionId : null,
            offerPeriod: property_exists($obj, "offerPeriod") && is_string($obj->offerPeriod)
                ? $obj->offerPeriod : null,
        );
    }
}
