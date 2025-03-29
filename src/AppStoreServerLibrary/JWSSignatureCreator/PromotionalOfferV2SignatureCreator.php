<?php

namespace AppStoreServerLibrary\JWSSignatureCreator;

use AppStoreServerLibrary\JWSSignatureCreator;

class PromotionalOfferV2SignatureCreator extends JWSSignatureCreator
{
    /**
     * Create a PromotionalOfferV2SignatureCreator
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
            audience: "promotional-offer",
            signingKey: $signingKey,
            keyId: $keyId,
            issuerId: $issuerId,
            bundleId: $bundleId
        );
    }

    /**
     * Create a promotional offer V2 signature.
     * https://developer.apple.com/documentation/storekit/generating-jws-to-sign-app-store-requests
     *
     * @param string $productId The unique identifier of the product
     * @param string $offerIdentifier The promotional offer identifier that you set up in App Store Connect
     * @param string|null $transactionId The unique identifier of any transaction that belongs to the customer. You can
     * use the customer's appTransactionId, even for customers who haven't made any In-App Purchases in your app. This
     * field is optional, but recommended.
     * @return string The signed JWS.
     */
    public function createSignature(
        string $productId,
        string $offerIdentifier,
        ?string $transactionId,
    ): string {
        $featureSpecificClaims = [
            "productId" => $productId,
            "offerIdentifier" => $offerIdentifier,
        ];
        if ($transactionId !== null) {
            $featureSpecificClaims["transactionId"] = $transactionId;
        }
        return $this->createSignatureFromClaims(featureSpecificClaims: $featureSpecificClaims);
    }
}
