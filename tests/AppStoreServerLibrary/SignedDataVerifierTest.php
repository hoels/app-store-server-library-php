<?php

namespace AppStoreServerLibrary\Tests;

use AppStoreServerLibrary\Models\AutoRenewStatus;
use AppStoreServerLibrary\Models\ConsumptionRequestReason;
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\Models\ExpirationIntent;
use AppStoreServerLibrary\Models\InAppOwnershipType;
use AppStoreServerLibrary\Models\NotificationTypeV2;
use AppStoreServerLibrary\Models\OfferDiscountType;
use AppStoreServerLibrary\Models\OfferType;
use AppStoreServerLibrary\Models\PriceIncreaseStatus;
use AppStoreServerLibrary\Models\RevocationReason;
use AppStoreServerLibrary\Models\Status;
use AppStoreServerLibrary\Models\Subtype;
use AppStoreServerLibrary\Models\TransactionReason;
use AppStoreServerLibrary\Models\Type;
use AppStoreServerLibrary\SignedDataVerifier;
use AppStoreServerLibrary\SignedDataVerifier\VerificationException;
use AppStoreServerLibrary\SignedDataVerifier\VerificationStatus;
use Firebase\JWT\JWT;
use PHPUnit\Framework\MockObject\Exception;
use PHPUnit\Framework\TestCase;
use ValueError;

class SignedDataVerifierTest extends TestCase
{
    const XCODE_BUNDLE_ID = "com.example.naturelab.backyardbirds.example";


    /**
     * @throws VerificationException
     */
    public function testSelfSignedAppTransactionDecoding(): void
    {
        $signedAppTransaction = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/appTransaction.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $appTransaction = $signedDataVerifier->verifyAndDecodeAppTransaction($signedAppTransaction);
        self::assertEquals(Environment::LOCAL_TESTING, $appTransaction->getReceiptType());
        self::assertEquals(531412, $appTransaction->getAppAppleId());
        self::assertEquals("com.example", $appTransaction->getBundleId());
        self::assertEquals("1.2.3", $appTransaction->getApplicationVersion());
        self::assertEquals(512, $appTransaction->getVersionExternalIdentifier());
        self::assertEquals(1698148900000, $appTransaction->getReceiptCreationDate());
        self::assertEquals(1698148800000, $appTransaction->getOriginalPurchaseDate());
        self::assertEquals("1.1.2", $appTransaction->getOriginalApplicationVersion());
        self::assertEquals("device_verification_value", $appTransaction->getDeviceVerification());
        self::assertEquals("48ccfa42-7431-4f22-9908-7e88983e105a", $appTransaction->getDeviceVerificationNonce());
        self::assertEquals(1698148700000, $appTransaction->getPreorderDate());
    }

    /**
     * @throws VerificationException
     */
    public function testSelfSignedTransactionDecoding(): void
    {
        $signedTransaction = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedTransaction.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $transaction = $signedDataVerifier->verifyAndDecodeSignedTransaction($signedTransaction);
        self::assertEquals("12345", $transaction->getOriginalTransactionId());
        self::assertEquals("23456", $transaction->getTransactionId());
        self::assertEquals("34343", $transaction->getWebOrderLineItemId());
        self::assertEquals("com.example", $transaction->getBundleId());
        self::assertEquals("com.example.product", $transaction->getProductId());
        self::assertEquals("55555", $transaction->getSubscriptionGroupIdentifier());
        self::assertEquals(1698148800000, $transaction->getOriginalPurchaseDate());
        self::assertEquals(1698148900000, $transaction->getPurchaseDate());
        self::assertEquals(1698148950000, $transaction->getRevocationDate());
        self::assertEquals(1698149000000, $transaction->getExpiresDate());
        self::assertEquals(1, $transaction->getQuantity());
        self::assertEquals(Type::AUTO_RENEWABLE_SUBSCRIPTION, $transaction->getType());
        self::assertEquals("7e3fb20b-4cdb-47cc-936d-99d65f608138", $transaction->getAppAccountToken());
        self::assertEquals(InAppOwnershipType::PURCHASED, $transaction->getInAppOwnershipType());
        self::assertEquals(1698148900000, $transaction->getSignedDate());
        self::assertEquals(RevocationReason::REFUNDED_DUE_TO_ISSUE, $transaction->getRevocationReason());
        self::assertEquals("abc.123", $transaction->getOfferIdentifier());
        self::assertTrue($transaction->getIsUpgraded());
        self::assertEquals(OfferType::INTRODUCTORY_OFFER, $transaction->getOfferType());
        self::assertEquals("USA", $transaction->getStorefront());
        self::assertEquals("143441", $transaction->getStorefrontId());
        self::assertEquals(TransactionReason::PURCHASE, $transaction->getTransactionReason());
        self::assertEquals(Environment::LOCAL_TESTING, $transaction->getEnvironment());
        self::assertEquals(10990, $transaction->getPrice());
        self::assertEquals("USD", $transaction->getCurrency());
        self::assertEquals(OfferDiscountType::PAY_AS_YOU_GO, $transaction->getOfferDiscountType());
    }

    /**
     * @throws VerificationException
     */
    public function testSelfSignedRenewalInfoDecoding(): void
    {
        $signedRenewalInfo = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedRenewalInfo.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $renewalInfo = $signedDataVerifier->verifyAndDecodeRenewalInfo($signedRenewalInfo);
        self::assertEquals(ExpirationIntent::CUSTOMER_CANCELLED, $renewalInfo->getExpirationIntent());
        self::assertEquals("12345", $renewalInfo->getOriginalTransactionId());
        self::assertEquals("com.example.product.2", $renewalInfo->getAutoRenewProductId());
        self::assertEquals("com.example.product", $renewalInfo->getProductId());
        self::assertEquals(AutoRenewStatus::ON, $renewalInfo->getAutoRenewStatus());
        self::assertTrue($renewalInfo->getIsInBillingRetryPeriod());
        self::assertEquals(PriceIncreaseStatus::CUSTOMER_HAS_NOT_RESPONDED, $renewalInfo->getPriceIncreaseStatus());
        self::assertEquals(1698148900000, $renewalInfo->getGracePeriodExpiresDate());
        self::assertEquals(OfferType::PROMOTIONAL_OFFER, $renewalInfo->getOfferType());
        self::assertEquals("abc.123", $renewalInfo->getOfferIdentifier());
        self::assertEquals(1698148800000, $renewalInfo->getSignedDate());
        self::assertEquals(Environment::LOCAL_TESTING, $renewalInfo->getEnvironment());
        self::assertEquals(1698148800000, $renewalInfo->getRecentSubscriptionStartDate());
        self::assertEquals(1698148850000, $renewalInfo->getRenewalDate());
        self::assertEquals("USD", $renewalInfo->getCurrency());
        self::assertEquals(9990, $renewalInfo->getRenewalPrice());
        self::assertEquals(OfferDiscountType::PAY_AS_YOU_GO, $renewalInfo->getOfferDiscountType());
        self::assertEquals(["eligible1", "eligible2"], $renewalInfo->getEligibleWinBackOfferIds());
    }

    /**
     * @throws VerificationException
     */
    public function testSelfSignedNotificationDecoding(): void
    {
        $signedNotification = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedNotification.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $notification = $signedDataVerifier->verifyAndDecodeNotification($signedNotification);
        self::assertEquals(NotificationTypeV2::SUBSCRIBED, $notification->getNotificationType());
        self::assertEquals(Subtype::INITIAL_BUY, $notification->getSubtype());
        self::assertEquals("002e14d5-51f5-4503-b5a8-c3a1af68eb20", $notification->getNotificationUUID());
        self::assertEquals("2.0", $notification->getVersion());
        self::assertEquals(1698148900000, $notification->getSignedDate());
        self::assertNotNull($notification->getData());
        self::assertNull($notification->getSummary());
        self::assertNull($notification->getExternalPurchaseToken());
        self::assertEquals(Environment::LOCAL_TESTING, $notification->getData()->getEnvironment());
        self::assertEquals(41234, $notification->getData()->getAppAppleId());
        self::assertEquals("com.example", $notification->getData()->getBundleId());
        self::assertEquals("1.2.3", $notification->getData()->getBundleVersion());
        self::assertEquals("signed_transaction_info_value", $notification->getData()->getSignedTransactionInfo());
        self::assertEquals("signed_renewal_info_value", $notification->getData()->getSignedRenewalInfo());
        self::assertEquals(Status::ACTIVE, $notification->getData()->getStatus());
        self::assertNull($notification->getData()->getConsumptionRequestReason());
    }

    /**
     * @throws VerificationException
     */
    public function testSelfSignedConsumptionRequestNotificationDecoding(): void
    {
        $signedNotification = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedConsumptionRequestNotification.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $notification = $signedDataVerifier->verifyAndDecodeNotification($signedNotification);
        self::assertEquals(NotificationTypeV2::CONSUMPTION_REQUEST, $notification->getNotificationType());
        self::assertNull($notification->getSubtype());
        self::assertEquals("002e14d5-51f5-4503-b5a8-c3a1af68eb20", $notification->getNotificationUUID());
        self::assertEquals("2.0", $notification->getVersion());
        self::assertEquals(1698148900000, $notification->getSignedDate());
        self::assertNotNull($notification->getData());
        self::assertNull($notification->getSummary());
        self::assertNull($notification->getExternalPurchaseToken());
        self::assertEquals(Environment::LOCAL_TESTING, $notification->getData()->getEnvironment());
        self::assertEquals(41234, $notification->getData()->getAppAppleId());
        self::assertEquals("com.example", $notification->getData()->getBundleId());
        self::assertEquals("1.2.3", $notification->getData()->getBundleVersion());
        self::assertEquals("signed_transaction_info_value", $notification->getData()->getSignedTransactionInfo());
        self::assertEquals("signed_renewal_info_value", $notification->getData()->getSignedRenewalInfo());
        self::assertEquals(Status::ACTIVE, $notification->getData()->getStatus());
        self::assertEquals(
            ConsumptionRequestReason::UNINTENDED_PURCHASE,
            $notification->getData()->getConsumptionRequestReason()
        );
    }

    /**
     * @throws VerificationException
     */
    public function testSelfSignedSummaryNotificationDecoding(): void
    {
        $signedSummaryNotification = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedSummaryNotification.json"
        );
        $signedDataVerifier = $this->getDefaultSignedDataVerifier();

        $notification = $signedDataVerifier->verifyAndDecodeNotification($signedSummaryNotification);
        self::assertEquals(NotificationTypeV2::RENEWAL_EXTENSION, $notification->getNotificationType());
        self::assertEquals(Subtype::SUMMARY, $notification->getSubtype());
        self::assertEquals("002e14d5-51f5-4503-b5a8-c3a1af68eb20", $notification->getNotificationUUID());
        self::assertEquals("2.0", $notification->getVersion());
        self::assertEquals(1698148900000, $notification->getSignedDate());
        self::assertNull($notification->getData());
        self::assertNotNull($notification->getSummary());
        self::assertNull($notification->getExternalPurchaseToken());
        self::assertEquals(Environment::LOCAL_TESTING, $notification->getSummary()->getEnvironment());
        self::assertEquals(41234, $notification->getSummary()->getAppAppleId());
        self::assertEquals("com.example", $notification->getSummary()->getBundleId());
        self::assertEquals("com.example.product", $notification->getSummary()->getProductId());
        self::assertEquals("efb27071-45a4-4aca-9854-2a1e9146f265", $notification->getSummary()->getRequestIdentifier());
        self::assertEquals(["CAN", "USA", "MEX"], $notification->getSummary()->getStorefrontCountryCodes());
        self::assertEquals(5, $notification->getSummary()->getSucceededCount());
        self::assertEquals(2, $notification->getSummary()->getFailedCount());
    }

    /**
     * @throws Exception|VerificationException
     */
    public function testSelfSignedExternalPurchaseTokenNotificationDecoding(): void
    {
        $signedSummaryNotification = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedExternalPurchaseTokenNotification.json"
        );
        $signedDataVerifierMock = $this->getMockedSignedDataVerifier(environment: Environment::PRODUCTION);

        $notification = $signedDataVerifierMock->verifyAndDecodeNotification($signedSummaryNotification);
        self::assertEquals(NotificationTypeV2::EXTERNAL_PURCHASE_TOKEN, $notification->getNotificationType());
        self::assertEquals(Subtype::UNREPORTED, $notification->getSubtype());
        self::assertEquals("002e14d5-51f5-4503-b5a8-c3a1af68eb20", $notification->getNotificationUUID());
        self::assertEquals("2.0", $notification->getVersion());
        self::assertEquals(1698148900000, $notification->getSignedDate());
        self::assertNull($notification->getData());
        self::assertNull($notification->getSummary());
        self::assertNotNull($notification->getExternalPurchaseToken());
        self::assertEquals(
            "b2158121-7af9-49d4-9561-1f588205523e",
            $notification->getExternalPurchaseToken()->getExternalPurchaseId()
        );
        self::assertEquals(1698148950000, $notification->getExternalPurchaseToken()->getTokenCreationDate());
        self::assertEquals(55555, $notification->getExternalPurchaseToken()->getAppAppleId());
        self::assertEquals("com.example", $notification->getExternalPurchaseToken()->getBundleId());
    }

    /**
     * @throws Exception|VerificationException
     */
    public function testSelfSignedExternalPurchaseTokenSandboxNotificationDecoding(): void
    {
        $signedSummaryNotification = $this->createSignedDataFromJson(
            path: __DIR__ . "/resources/models/signedExternalPurchaseTokenSandboxNotification.json"
        );
        $signedDataVerifierMock = $this->getMockedSignedDataVerifier(environment: Environment::SANDBOX);

        $signedDataVerifierMock->verifyAndDecodeNotification($signedSummaryNotification);
    }

    /**
     * @throws VerificationException
     */
    public function testAppStoreServerNotificationDecoding(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::SANDBOX, bundleId: "com.example");
        $testNotification = file_get_contents(__DIR__ . "/resources/mock_signed_data/testNotification");
        $notification = $verifier->verifyAndDecodeNotification($testNotification);
        self::assertEquals(NotificationTypeV2::TEST, $notification->getNotificationType());
    }

    /**
     * @throws VerificationException
     */
    public function testAppStoreServerNotificationDecodingProduction(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::PRODUCTION, bundleId: "com.example");
        $testNotification = file_get_contents(__DIR__ . "/resources/mock_signed_data/testNotification");
        try {
            $verifier->verifyAndDecodeNotification($testNotification);
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_ENVIRONMENT, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testMissingX5CHeader(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::SANDBOX, bundleId: "com.example");
        $testNotification = file_get_contents(__DIR__ . "/resources/mock_signed_data/missingX5CHeaderClaim");
        try {
            $verifier->verifyAndDecodeNotification($testNotification);
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_JWT_FORMAT, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testWrongBundleIdForServerNotification(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::SANDBOX, bundleId: "com.examplex");
        $testNotification = file_get_contents(__DIR__ . "/resources/mock_signed_data/wrongBundleId");
        try {
            $verifier->verifyAndDecodeNotification($testNotification);
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_APP_IDENTIFIER, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testWrongAppAppleIdForServerNotification(): void
    {
        $verifier = $this->getSignedDataVerifier(
            environment: Environment::PRODUCTION,
            bundleId: "com.example",
            appAppleId: 1235
        );
        $testNotification = file_get_contents(__DIR__ . "/resources/mock_signed_data/testNotification");
        try {
            $verifier->verifyAndDecodeNotification($testNotification);
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_APP_IDENTIFIER, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testRenewalInfoDecoding(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::SANDBOX, bundleId: "com.example");
        $testRenewalInfo = file_get_contents(__DIR__ . "/resources/mock_signed_data/renewalInfo");
        $renewalInfo = $verifier->verifyAndDecodeRenewalInfo($testRenewalInfo);
        self::assertEquals(Environment::SANDBOX, $renewalInfo->getEnvironment());
    }

    /**
     * @throws VerificationException
     */
    public function testTransactionDecoding(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::SANDBOX, bundleId: "com.example");
        $testTransaction = file_get_contents(__DIR__ . "/resources/mock_signed_data/transactionInfo");
        $transaction = $verifier->verifyAndDecodeSignedTransaction($testTransaction);
        self::assertEquals(Environment::SANDBOX, $transaction->getEnvironment());
    }

    /**
     * @throws VerificationException
     */
    public function testMalformedJwtWithTooManyParts(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::PRODUCTION, bundleId: "com.example");
        try {
            $verifier->verifyAndDecodeNotification("a.b.c.d");
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_JWT_FORMAT, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testMalformedJwtWithMalformedData(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::PRODUCTION, bundleId: "com.example");
        try {
            $verifier->verifyAndDecodeNotification("a.b.c");
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_JWT_FORMAT, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    /**
     * @throws VerificationException
     */
    public function testXcodeSignedAppTransaction(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::XCODE, bundleId: self::XCODE_BUNDLE_ID);
        $encodedAppTransaction = file_get_contents(__DIR__ . "/resources/xcode/xcode-signed-app-transaction");

        $appTransaction = $verifier->verifyAndDecodeAppTransaction($encodedAppTransaction);
        self::assertNull($appTransaction->getAppAppleId());
        self::assertEquals(self::XCODE_BUNDLE_ID, $appTransaction->getBundleId());
        self::assertEquals("1", $appTransaction->getApplicationVersion());
        self::assertNull($appTransaction->getVersionExternalIdentifier());
        self::assertEquals(-62135769600000, $appTransaction->getOriginalPurchaseDate());
        self::assertEquals("1", $appTransaction->getOriginalApplicationVersion());
        self::assertEquals(
            "cYUsXc53EbYc0pOeXG5d6/31LGHeVGf84sqSN0OrJi5u/j2H89WWKgS8N0hMsMlf",
            $appTransaction->getDeviceVerification()
        );
        self::assertEquals("48c8b92d-ce0d-4229-bedf-e61b4f9cfc92", $appTransaction->getDeviceVerificationNonce());
        self::assertNull($appTransaction->getPreorderDate());
        self::assertEquals(Environment::XCODE, $appTransaction->getReceiptType());
    }

    /**
     * @throws VerificationException
     */
    public function testXcodeSignedTransaction(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::XCODE, bundleId: self::XCODE_BUNDLE_ID);
        $encodedTransaction = file_get_contents(__DIR__ . "/resources/xcode/xcode-signed-transaction");

        $transaction = $verifier->verifyAndDecodeSignedTransaction($encodedTransaction);
        self::assertEquals("0", $transaction->getOriginalTransactionId());
        self::assertEquals("0", $transaction->getTransactionId());
        self::assertEquals("0", $transaction->getWebOrderLineItemId());
        self::assertEquals(self::XCODE_BUNDLE_ID, $transaction->getBundleId());
        self::assertEquals("pass.premium", $transaction->getProductId());
        self::assertEquals("6F3A93AB", $transaction->getSubscriptionGroupIdentifier());
        self::assertEquals(1697679936049, $transaction->getPurchaseDate());
        self::assertEquals(1697679936049, $transaction->getOriginalPurchaseDate());
        self::assertEquals(1700358336049, $transaction->getExpiresDate());
        self::assertEquals(1, $transaction->getQuantity());
        self::assertEquals(Type::AUTO_RENEWABLE_SUBSCRIPTION, $transaction->getType());
        self::assertNull($transaction->getAppAccountToken());
        self::assertEquals(InAppOwnershipType::PURCHASED, $transaction->getInAppOwnershipType());
        self::assertEquals(1697679936056, $transaction->getSignedDate());
        self::assertNull($transaction->getRevocationReason());
        self::assertNull($transaction->getRevocationDate());
        self::assertFalse($transaction->getIsUpgraded());
        self::assertEquals(OfferType::INTRODUCTORY_OFFER, $transaction->getOfferType());
        self::assertNull($transaction->getOfferIdentifier());
        self::assertEquals(Environment::XCODE, $transaction->getEnvironment());
        self::assertEquals("USA", $transaction->getStorefront());
        self::assertEquals("143441", $transaction->getStorefrontId());
        self::assertEquals(TransactionReason::PURCHASE, $transaction->getTransactionReason());
    }

    /**
     * @throws VerificationException
     */
    public function testXcodeSignedRenewalInfo(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::XCODE, bundleId: self::XCODE_BUNDLE_ID);
        $encodedRenewalInfo = file_get_contents(__DIR__ . "/resources/xcode/xcode-signed-renewal-info");

        $renewalInfo = $verifier->verifyAndDecodeRenewalInfo($encodedRenewalInfo);
        self::assertNull($renewalInfo->getExpirationIntent());
        self::assertEquals("0", $renewalInfo->getOriginalTransactionId());
        self::assertEquals("pass.premium", $renewalInfo->getAutoRenewProductId());
        self::assertEquals("pass.premium", $renewalInfo->getProductId());
        self::assertEquals(AutoRenewStatus::ON, $renewalInfo->getAutoRenewStatus());
        self::assertNull($renewalInfo->getIsInBillingRetryPeriod());
        self::assertNull($renewalInfo->getPriceIncreaseStatus());
        self::assertNull($renewalInfo->getGracePeriodExpiresDate());
        self::assertNull($renewalInfo->getOfferType());
        self::assertNull($renewalInfo->getOfferIdentifier());
        self::assertEquals(1697679936711, $renewalInfo->getSignedDate());
        self::assertEquals(Environment::XCODE, $renewalInfo->getEnvironment());
        self::assertEquals(1697679936049, $renewalInfo->getRecentSubscriptionStartDate());
        self::assertEquals(1700358336049, $renewalInfo->getRenewalDate());
    }

    /**
     * @throws VerificationException
     */
    public function testXcodeSignedAppTransactionWIthProductionEnvironment(): void
    {
        $verifier = $this->getSignedDataVerifier(environment: Environment::PRODUCTION, bundleId: self::XCODE_BUNDLE_ID);
        $encodedAppTransaction = file_get_contents(__DIR__ . "/resources/xcode/xcode-signed-app-transaction");

        try {
            $verifier->verifyAndDecodeAppTransaction($encodedAppTransaction);
        } catch (VerificationException $e) {
            self::assertEquals(VerificationStatus::INVALID_JWT_FORMAT, $e->getStatus());
            return;
        }
        self::fail("Expected VerificationException.");
    }

    private function createSignedDataFromJson(string $path): string
    {
        $data = file_get_contents($path);
        $decodedData = json_decode($data, associative: true);
        $privateKey = openssl_pkey_new(options: [
            "private_key_type" => OPENSSL_KEYTYPE_EC,
            "curve_name" => "prime256v1",
        ]);
        return JWT::encode(payload: $decodedData, key: $privateKey, alg: "ES256");
    }

    /**
     * @throws VerificationException|ValueError
     */
    private function getSignedDataVerifier(
        Environment $environment,
        string $bundleId,
        int $appAppleId = 1234
    ): SignedDataVerifier {
        return new SignedDataVerifier(
            rootCertificates: [file_get_contents(__DIR__ . "/resources/certs/testCA.der")],
            enableOnlineChecks: false,
            environment: $environment,
            bundleId: $bundleId,
            appAppleId: $appAppleId
        );
    }

    /**
     * @throws VerificationException|ValueError
     */
    private function getDefaultSignedDataVerifier(): SignedDataVerifier
    {
        return $this->getSignedDataVerifier(environment: Environment::LOCAL_TESTING, bundleId: "com.example");
    }

    /**
     * @throws Exception
     */
    private function getMockedSignedDataVerifier(
        Environment $environment
    ): SignedDataVerifier {
        $signedDataVerifierMock = $this->getMockBuilder(SignedDataVerifier::class)
            ->setConstructorArgs([
                [file_get_contents(__DIR__ . "/resources/certs/testCA.der")], // rootCertificates
                false, // enableOnlineChecks
                Environment::LOCAL_TESTING, // environment
                "com.example", // bundleId
                55555 // appAppleId
            ])
            ->disableOriginalClone()
            ->onlyMethods(["verifyNotification"])
            ->getMock();
        $signedDataVerifierMock
            ->expects($this->once())
            ->method("verifyNotification")
            ->with(
                "com.example", // bundleId
                55555, // appAppleId
                $environment // environment
            );

        return $signedDataVerifierMock;
    }
}
