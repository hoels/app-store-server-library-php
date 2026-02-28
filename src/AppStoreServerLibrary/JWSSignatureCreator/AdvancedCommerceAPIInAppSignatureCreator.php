<?php

namespace AppStoreServerLibrary\JWSSignatureCreator;

use AppStoreServerLibrary\JWSSignatureCreator;
use AppStoreServerLibrary\Models\AdvancedCommerceAPIInAppRequest;

class AdvancedCommerceAPIInAppSignatureCreator extends JWSSignatureCreator
{
    /**
     * Create a AdvancedCommerceAPIInAppSignatureCreator
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
            audience: "advanced-commerce-api",
            signingKey: $signingKey,
            keyId: $keyId,
            issuerId: $issuerId,
            bundleId: $bundleId
        );
    }

    /**
     * Create an Advanced Commerce in-app signed request.
     * https://developer.apple.com/documentation/storekit/generating-jws-to-sign-app-store-requests
     *
     * @param AdvancedCommerceAPIInAppRequest $advancedCommerceInAppRequest The request to be signed.
     * @return string The signed JWS.
     */
    public function createSignature(AdvancedCommerceAPIInAppRequest $advancedCommerceInAppRequest): string
    {
        /** @var non-empty-string $jsonEncodedRequest */
        $jsonEncodedRequest = json_encode(get_object_vars($advancedCommerceInAppRequest));
        return $this->createSignatureFromClaims(featureSpecificClaims: [
            "request" => base64_encode($jsonEncodedRequest),
        ]);
    }
}
