<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The payload data that contains an external purchase token.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/externalpurchasetoken
 */
class ExternalPurchaseToken
{
    public function __construct(
        private readonly ?string $externalPurchaseId,
        private readonly ?int $tokenCreationDate,
        private readonly ?int $appAppleId,
        private readonly ?string $bundleId,
        private readonly ?TokenType $tokenType,
        private readonly ?int $tokenExpirationDate,
    ) {
    }

    /**
     * The field of an external purchase token that uniquely identifies the token.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/externalpurchaseid
     */
    public function getExternalPurchaseId(): ?string
    {
        return $this->externalPurchaseId;
    }

    /**
     * The field of an external purchase token that contains the UNIX date, in milliseconds, when the system created
     * the token.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/tokencreationdate
     */
    public function getTokenCreationDate(): ?int
    {
        return $this->tokenCreationDate;
    }

    /**
     * The unique identifier of an app in the App Store.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/appappleid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * The bundle identifier of an app.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/bundleid
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
    }

    /**
     * The type of an external purchase custom link token.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/tokentype
     */
    public function getTokenType(): ?TokenType
    {
        return $this->tokenType;
    }

    /**
     * The field of a custom link token that contains the UNIX date, in milliseconds, when the token expires.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/tokenexpirationdate
     */
    public function getTokenExpirationDate(): ?int
    {
        return $this->tokenExpirationDate;
    }

    public static function fromObject(stdClass $obj): ExternalPurchaseToken
    {
        return new ExternalPurchaseToken(
            externalPurchaseId: property_exists($obj, "externalPurchaseId") && is_string($obj->externalPurchaseId)
                ? $obj->externalPurchaseId : null,
            tokenCreationDate: property_exists($obj, "tokenCreationDate")
                && (is_int($obj->tokenCreationDate) || is_float($obj->tokenCreationDate))
                ? intval($obj->tokenCreationDate) : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            tokenType: property_exists($obj, "tokenType") && is_string($obj->tokenType)
                ? TokenType::tryFrom($obj->tokenType) : null,
            tokenExpirationDate: property_exists($obj, "tokenExpirationDate")
                && is_int($obj->tokenExpirationDate)
                ? $obj->tokenExpirationDate : null,
        );
    }
}
