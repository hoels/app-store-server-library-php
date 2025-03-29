<?php

namespace AppStoreServerLibrary\JWSSignatureCreator;

use AppStoreServerLibrary\JWSSignatureCreator;

class IntroductoryOfferEligibilitySignatureCreator extends JWSSignatureCreator
{
    /**
     * Create an IntroductoryOfferEligibilitySignatureCreator
     *
     * @param string $signingKey Your private key downloaded from App Store Connect
     * @param string $keyId Your private key ID from App Store Connect
     * @param string $issuerId Your issuer ID from the Keys page in App Store Connect
     * @param string $bundleId Your app's bundle ID
     */
    public function __construct(
        string $signingKey,
        string $keyId,
        string $issuerId,
        string $bundleId
    ) {
        parent::__construct(
            audience: "introductory-offer-eligibility",
            signingKey: $signingKey,
            keyId: $keyId,
            issuerId: $issuerId,
            bundleId: $bundleId
        );
    }

    /**
     * Create an introductory offer eligibility signature.
     * https://developer.apple.com/documentation/storekit/generating-jws-to-sign-app-store-requests
     *
     * @param string $productId The unique identifier of the product
     * @param bool $allowIntroductoryOffer A boolean value that determines whether the customer is eligible for an
     * introductory offer
     * @param string $transactionId The unique identifier of any transaction that belongs to the customer. You can use
     * the customer's appTransactionId, even for customers who haven't made any In-App Purchases in your app.
     * @return string The signed JWS.
     */
    public function createSignature(
        string $productId,
        bool $allowIntroductoryOffer,
        string $transactionId,
    ): string {
        return $this->createSignatureFromClaims(featureSpecificClaims: [
            "productId" => $productId,
            "allowIntroductoryOffer" => $allowIntroductoryOffer,
            "transactionId" => $transactionId,
        ]);
    }
}
