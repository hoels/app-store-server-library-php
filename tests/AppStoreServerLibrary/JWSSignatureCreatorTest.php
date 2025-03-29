<?php

namespace AppStoreServerLibrary\Tests;

use AppStoreServerLibrary\JWSSignatureCreator\AdvancedCommerceAPIInAppSignatureCreator;
use AppStoreServerLibrary\JWSSignatureCreator\IntroductoryOfferEligibilitySignatureCreator;
use AppStoreServerLibrary\JWSSignatureCreator\PromotionalOfferV2SignatureCreator;
use AppStoreServerLibrary\Tests\JWSSignatureCreatorTest\TestInAppRequest;
use PHPUnit\Framework\TestCase;

class JWSSignatureCreatorTest extends TestCase
{
    public function testPromotionalOfferSignatureCreator(): void
    {
        $signatureCreator = new PromotionalOfferV2SignatureCreator(
            signingKey: $this->getSigningKey(),
            keyId: "keyId",
            issuerId: "issuerId",
            bundleId: "bundleId",
        );
        $signature = $signatureCreator->createSignature(
            productId: "productId",
            offerIdentifier: "offerIdentifier",
            transactionId: "transactionId"
        );
        $headers = json_decode(base64_decode(explode(".", $signature)[0]), associative: true);
        $payload = json_decode(base64_decode(explode(".", $signature)[1]), associative: true);

        // Header
        self::assertEquals("JWT", $headers["typ"]);
        self::assertEquals("ES256", $headers["alg"]);
        self::assertEquals("keyId", $headers["kid"]);

        // Payload
        self::assertEquals("issuerId", $payload["iss"]);
        self::assertNotNull($payload["iat"]);
        self::assertArrayNotHasKey("exp", $payload);
        self::assertEquals("promotional-offer", $payload["aud"]);
        self::assertEquals("bundleId", $payload["bid"]);
        self::assertNotNull($payload["nonce"]);
        self::assertEquals("productId", $payload["productId"]);
        self::assertEquals("offerIdentifier", $payload["offerIdentifier"]);
        self::assertEquals("transactionId", $payload["transactionId"]);
    }

    public function testPromotionalOfferSignatureCreatorTransactionIdMissing(): void
    {
        $signatureCreator = new PromotionalOfferV2SignatureCreator(
            signingKey: $this->getSigningKey(),
            keyId: "keyId",
            issuerId: "issuerId",
            bundleId: "bundleId",
        );
        $signature = $signatureCreator->createSignature(
            productId: "productId",
            offerIdentifier: "offerIdentifier",
            transactionId: null
        );
        $payload = json_decode(base64_decode(explode(".", $signature)[1]), associative: true);
        self::assertArrayNotHasKey("transactionId", $payload);
    }

    public function testIntroductoryOfferEligibilitySignatureCreator(): void
    {
        $signatureCreator = new IntroductoryOfferEligibilitySignatureCreator(
            signingKey: $this->getSigningKey(),
            keyId: "keyId",
            issuerId: "issuerId",
            bundleId: "bundleId",
        );
        $signature = $signatureCreator->createSignature(
            productId: "productId",
            allowIntroductoryOffer: true,
            transactionId: "transactionId"
        );
        $headers = json_decode(base64_decode(explode(".", $signature)[0]), associative: true);
        $payload = json_decode(base64_decode(explode(".", $signature)[1]), associative: true);

        // Header
        self::assertEquals("JWT", $headers["typ"]);
        self::assertEquals("ES256", $headers["alg"]);
        self::assertEquals("keyId", $headers["kid"]);

        // Payload
        self::assertEquals("issuerId", $payload["iss"]);
        self::assertNotNull($payload["iat"]);
        self::assertArrayNotHasKey("exp", $payload);
        self::assertEquals("introductory-offer-eligibility", $payload["aud"]);
        self::assertEquals("bundleId", $payload["bid"]);
        self::assertNotNull($payload["nonce"]);
        self::assertEquals("productId", $payload["productId"]);
        self::assertTrue($payload["allowIntroductoryOffer"]);
        self::assertEquals("transactionId", $payload["transactionId"]);
    }

    public function testAdvancedCommerceAPIInAppSignatureCreator(): void
    {
        $signatureCreator = new AdvancedCommerceAPIInAppSignatureCreator(
            signingKey: $this->getSigningKey(),
            keyId: "keyId",
            issuerId: "issuerId",
            bundleId: "bundleId",
        );
        $signature = $signatureCreator->createSignature(new TestInAppRequest("testValue"));
        $headers = json_decode(base64_decode(explode(".", $signature)[0]), associative: true);
        $payload = json_decode(base64_decode(explode(".", $signature)[1]), associative: true);

        // Header
        self::assertEquals("JWT", $headers["typ"]);
        self::assertEquals("ES256", $headers["alg"]);
        self::assertEquals("keyId", $headers["kid"]);

        // Payload
        self::assertEquals("issuerId", $payload["iss"]);
        self::assertNotNull($payload["iat"]);
        self::assertArrayNotHasKey("exp", $payload);
        self::assertEquals("advanced-commerce-api", $payload["aud"]);
        self::assertEquals("bundleId", $payload["bid"]);
        self::assertNotNull($payload["nonce"]);
        $request = $payload["request"];
        $decodeJson = json_decode(base64_decode($request), associative: true);
        self::assertEquals("testValue", $decodeJson["testValue"]);
    }

    private function getSigningKey(): string
    {
        $signingKey = file_get_contents(__DIR__ . "/resources/certs/testSigningKey.p8");
        self::assertNotFalse($signingKey);

        return $signingKey;
    }
}
