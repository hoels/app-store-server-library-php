<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A decoded payload containing transaction information.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/jwstransactiondecodedpayload
 */
class JWSTransactionDecodedPayload
{
    public function __construct(
        private readonly ?string $originalTransactionId,
        private readonly ?string $transactionId,
        private readonly ?string $webOrderLineItemId,
        private readonly ?string $bundleId,
        private readonly ?string $productId,
        private readonly ?string $subscriptionGroupIdentifier,
        private readonly ?int $purchaseDate,
        private readonly ?int $originalPurchaseDate,
        private readonly ?int $expiresDate,
        private readonly ?int $quantity,
        private readonly ?Type $type,
        private readonly ?string $appAccountToken,
        private readonly ?InAppOwnershipType $inAppOwnershipType,
        private readonly ?int $signedDate,
        private readonly ?RevocationReason $revocationReason,
        private readonly ?int $revocationDate,
        private readonly ?bool $isUpgraded,
        private readonly ?OfferType $offerType,
        private readonly ?string $offerIdentifier,
        private readonly ?Environment $environment,
        private readonly ?string $storefront,
        private readonly ?string $storefrontId,
        private readonly ?TransactionReason $transactionReason,
        private readonly ?string $currency,
        private readonly ?int $price,
        private readonly ?OfferDiscountType $offerDiscountType,
    ) {
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
     * The unique identifier for a transaction such as an in-app purchase, restored in-app purchase, or subscription
     * renewal.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/transactionid
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * The unique identifier of subscription-purchase events across devices, including renewals.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/weborderlineitemid
     */
    public function getWebOrderLineItemId(): ?string
    {
        return $this->webOrderLineItemId;
    }

    /**
     * The bundle identifier of an app.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/bundleid
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
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
     * The identifier of the subscription group that the subscription belongs to.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     */
    public function getSubscriptionGroupIdentifier(): ?string
    {
        return $this->subscriptionGroupIdentifier;
    }

    /**
     * The time that the App Store charged the user's account for an in-app purchase, a restored in-app purchase, a
     * subscription, or a subscription renewal after a lapse.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/purchasedate
     */
    public function getPurchaseDate(): ?int
    {
        return $this->purchaseDate;
    }

    /**
     * The purchase date of the transaction associated with the original transaction identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/originalpurchasedate
     */
    public function getOriginalPurchaseDate(): ?int
    {
        return $this->originalPurchaseDate;
    }

    /**
     * The UNIX time, in milliseconds, an auto-renewable subscription expires or renews.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/expiresdate
     */
    public function getExpiresDate(): ?int
    {
        return $this->expiresDate;
    }

    /**
     * The number of consumable products purchased.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/quantity
     */
    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    /**
     * The type of the in-app purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/type
     */
    public function getType(): ?Type
    {
        return $this->type;
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
     * A string that describes whether the transaction was purchased by the user, or is available to them through
     * Family Sharing.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/inappownershiptype
     */
    public function getInAppOwnershipType(): ?InAppOwnershipType
    {
        return $this->inAppOwnershipType;
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
     * The reason that the App Store refunded the transaction or revoked it from family sharing.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/revocationreason
     */
    public function getRevocationReason(): ?RevocationReason
    {
        return $this->revocationReason;
    }

    /**
     * The UNIX time, in milliseconds, that Apple Support refunded a transaction.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/revocationdate
     */
    public function getRevocationDate(): ?int
    {
        return $this->revocationDate;
    }

    /**
     * The Boolean value that indicates whether the user upgraded to another subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/isupgraded
     */
    public function getIsUpgraded(): ?bool
    {
        return $this->isUpgraded;
    }

    /**
     * A value that represents the promotional offer type.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offertype
     */
    public function getOfferType(): ?OfferType
    {
        return $this->offerType;
    }

    /**
     * The identifier that contains the promo code or the promotional offer identifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offeridentifier
     */
    public function getOfferIdentifier(): ?string
    {
        return $this->offerIdentifier;
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
     * The three-letter code that represents the country or region associated with the App Store storefront for the
     * purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/storefront
     */
    public function getStorefront(): ?string
    {
        return $this->storefront;
    }

    /**
     * An Apple-defined value that uniquely identifies the App Store storefront associated with the purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/storefrontid
     */
    public function getStorefrontId(): ?string
    {
        return $this->storefrontId;
    }

    /**
     * The reason for the purchase transaction, which indicates whether it's a customer's purchase or a renewal for an
     * auto-renewable subscription that the system initiates.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/transactionreason
     */
    public function getTransactionReason(): ?TransactionReason
    {
        return $this->transactionReason;
    }

    /**
     * The three-letter ISO 4217 currency code for the price of the product.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/currency
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * The price, in milliunits, of the in-app purchase or subscription offer that you configured in App Store Connect.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/price
     */
    public function getPrice(): ?int
    {
        return $this->price;
    }

    /**
     * The payment mode you configure for an introductory offer, promotional offer, or offer code on an auto-renewable
     * subscription.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
     */
    public function getOfferDiscountType(): ?OfferDiscountType
    {
        return $this->offerDiscountType;
    }

    public static function fromObject(stdClass $obj): JWSTransactionDecodedPayload
    {
        return new JWSTransactionDecodedPayload(
            originalTransactionId: property_exists($obj, "originalTransactionId")
                && is_string($obj->originalTransactionId)
                ? $obj->originalTransactionId : null,
            transactionId: property_exists($obj, "transactionId") && is_string($obj->transactionId)
                ? $obj->transactionId : null,
            webOrderLineItemId: property_exists($obj, "webOrderLineItemId") && is_string($obj->webOrderLineItemId)
                ? $obj->webOrderLineItemId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            productId: property_exists($obj, "productId") && is_string($obj->productId)
                ? $obj->productId : null,
            subscriptionGroupIdentifier: property_exists($obj, "subscriptionGroupIdentifier")
                && is_string($obj->subscriptionGroupIdentifier)
                ? $obj->subscriptionGroupIdentifier : null,
            purchaseDate: property_exists($obj, "purchaseDate")
                && (is_int($obj->purchaseDate) || is_float($obj->purchaseDate))
                ? intval($obj->purchaseDate) : null,
            originalPurchaseDate: property_exists($obj, "originalPurchaseDate")
                && (is_int($obj->originalPurchaseDate) || is_float($obj->originalPurchaseDate))
                ? intval($obj->originalPurchaseDate) : null,
            expiresDate: property_exists($obj, "expiresDate")
                && (is_int($obj->expiresDate) || is_float($obj->expiresDate))
                ? intval($obj->expiresDate) : null,
            quantity: property_exists($obj, "quantity") && is_int($obj->quantity)
                ? $obj->quantity : null,
            type: property_exists($obj, "type") && is_string($obj->type)
                ? Type::tryFrom($obj->type) : null,
            appAccountToken: property_exists($obj, "appAccountToken") && is_string($obj->appAccountToken)
                ? $obj->appAccountToken : null,
            inAppOwnershipType: property_exists($obj, "inAppOwnershipType") && is_string($obj->inAppOwnershipType)
                ? InAppOwnershipType::tryFrom($obj->inAppOwnershipType) : null,
            signedDate: property_exists($obj, "signedDate")
                && (is_int($obj->signedDate) || is_float($obj->signedDate))
                ? intval($obj->signedDate) : null,
            revocationReason: property_exists($obj, "revocationReason") && is_int($obj->revocationReason)
                ? RevocationReason::tryFrom($obj->revocationReason) : null,
            revocationDate: property_exists($obj, "revocationDate")
                && (is_int($obj->revocationDate) || is_float($obj->revocationDate))
                ? intval($obj->revocationDate) : null,
            isUpgraded: property_exists($obj, "isUpgraded") && is_bool($obj->isUpgraded)
                ? $obj->isUpgraded : null,
            offerType: property_exists($obj, "offerType") && is_int($obj->offerType)
                ? OfferType::tryFrom($obj->offerType) : null,
            offerIdentifier: property_exists($obj, "offerIdentifier") && is_string($obj->offerIdentifier)
                ? $obj->offerIdentifier : null,
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
            storefront: property_exists($obj, "storefront") && is_string($obj->storefront)
                ? $obj->storefront : null,
            storefrontId: property_exists($obj, "storefrontId") && is_string($obj->storefrontId)
                ? $obj->storefrontId : null,
            transactionReason: property_exists($obj, "transactionReason") && is_string($obj->transactionReason)
                ? TransactionReason::tryFrom($obj->transactionReason) : null,
            currency: property_exists($obj, "currency") && is_string($obj->currency)
                ? $obj->currency : null,
            price: property_exists($obj, "price") && is_int($obj->price)
                ? $obj->price : null,
            offerDiscountType: property_exists($obj, "offerDiscountType") && is_string($obj->offerDiscountType)
                ? OfferDiscountType::tryFrom($obj->offerDiscountType) : null,
        );
    }
}
