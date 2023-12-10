<?php

namespace AppStoreServerLibrary\Tests;

use AppStoreServerLibrary\PromotionalOfferSignatureCreator;
use Exception;
use PHPUnit\Framework\TestCase;

class PromotionalOfferSignatureCreatorTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testCreateSignature(): void
    {
        $signingKey = file_get_contents(__DIR__ . "/resources/certs/testSigningKey.p8");
        $signatureCreator = new PromotionalOfferSignatureCreator(
            signingKey: $signingKey,
            keyId: "keyId",
            bundleId: "bundleId"
        );
        $signature = $signatureCreator->createSignature(
            productIdentifier: "productId",
            subscriptionOfferId: "offerId",
            applicationUsername: "applicationUsername",
            nonce: "20fba8a0-2b80-4a7d-a17f-85c1854727f8",
            timestamp: 1698148900000
        );

        $privateKey = openssl_pkey_get_private($signingKey);
        $publicKey = openssl_pkey_get_public(openssl_pkey_get_details($privateKey)["key"]);
        $verificationResult = openssl_verify(
            data: "bundleId" . mb_chr(0x2063)
            . "keyId" . mb_chr(0x2063)
            . "productId" . mb_chr(0x2063)
            . "offerId" . mb_chr(0x2063)
            . "applicationusername" . mb_chr(0x2063)
            . "20fba8a0-2b80-4a7d-a17f-85c1854727f8" . mb_chr(0x2063)
            . "1698148900000",
            signature: base64_decode($signature),
            public_key: $publicKey,
            algorithm: OPENSSL_ALGO_SHA256
        );
        self::assertEquals(1, $verificationResult);
    }
}
