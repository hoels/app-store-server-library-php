<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

class DecodedRealtimeRequestBody
{
    public function __construct(
        private readonly ?string $originalTransactionId,
        private readonly ?int $appAppleId,
        private readonly ?string $productId,
        private readonly ?string $userLocale,
        private readonly ?string $requestIdentifier,
        private readonly ?int $signedDate,
        private readonly ?Environment $environment,
    ) {
    }

    /**
     * The original transaction identifier of the customer's subscription.
     *
     * https://developer.apple.com/documentation/retentionmessaging/originaltransactionid
     */
    public function getOriginalTransactionId(): ?string
    {
        return $this->originalTransactionId;
    }

    /**
     * The unique identifier of the app in the App Store.
     *
     * https://developer.apple.com/documentation/retentionmessaging/appappleid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * The unique identifier of the auto-renewable subscription.
     *
     * https://developer.apple.com/documentation/retentionmessaging/productid
     */
    public function getProductId(): ?string
    {
        return $this->productId;
    }

    /**
     * The device's locale.
     *
     * https://developer.apple.com/documentation/retentionmessaging/locale
     */
    public function getUserLocale(): ?string
    {
        return $this->userLocale;
    }

    /**
     * A UUID the App Store server creates to uniquely identify each request.
     *
     * https://developer.apple.com/documentation/retentionmessaging/requestidentifier
     */
    public function getRequestIdentifier(): ?string
    {
        return $this->requestIdentifier;
    }

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature (JWS) data.
     *
     * https://developer.apple.com/documentation/retentionmessaging/signeddate
     */
    public function getSignedDate(): ?int
    {
        return $this->signedDate;
    }

    /**
     * The server environment, either sandbox or production.
     *
     * https://developer.apple.com/documentation/retentionmessaging/environment
     */
    public function getEnvironment(): ?Environment
    {
        return $this->environment;
    }

    public static function fromObject(stdClass $obj): DecodedRealtimeRequestBody
    {
        return new DecodedRealtimeRequestBody(
            originalTransactionId: property_exists($obj, "originalTransactionId")
                && is_string($obj->originalTransactionId)
                ? $obj->originalTransactionId : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            productId: property_exists($obj, "productId") && is_string($obj->productId)
                ? $obj->productId : null,
            userLocale: property_exists($obj, "userLocale") && is_string($obj->userLocale)
                ? $obj->userLocale : null,
            requestIdentifier: property_exists($obj, "requestIdentifier") && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null,
            signedDate: property_exists($obj, "signedDate") && is_int($obj->signedDate)
                ? $obj->signedDate : null,
            environment: property_exists($obj, "environment") && is_string($obj->environment)
                ? Environment::tryFrom($obj->environment) : null,
        );
    }
}
