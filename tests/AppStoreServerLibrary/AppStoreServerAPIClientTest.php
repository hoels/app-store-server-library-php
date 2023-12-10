<?php

namespace AppStoreServerLibrary\Tests;

use AppStoreServerLibrary\AppStoreServerAPIClient;
use AppStoreServerLibrary\AppStoreServerAPIClient\APIError;
use AppStoreServerLibrary\AppStoreServerAPIClient\APIException;
use AppStoreServerLibrary\Models\AccountTenure;
use AppStoreServerLibrary\Models\ConsumptionRequest;
use AppStoreServerLibrary\Models\ConsumptionStatus;
use AppStoreServerLibrary\Models\DeliveryStatus;
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\Models\ExtendReasonCode;
use AppStoreServerLibrary\Models\ExtendRenewalDateRequest;
use AppStoreServerLibrary\Models\InAppOwnershipType;
use AppStoreServerLibrary\Models\LastTransactionsItem;
use AppStoreServerLibrary\Models\LifetimeDollarsPurchased;
use AppStoreServerLibrary\Models\LifetimeDollarsRefunded;
use AppStoreServerLibrary\Models\MassExtendRenewalDateRequest;
use AppStoreServerLibrary\Models\NotificationHistoryRequest;
use AppStoreServerLibrary\Models\NotificationHistoryResponseItem;
use AppStoreServerLibrary\Models\NotificationTypeV2;
use AppStoreServerLibrary\Models\OrderLookupStatus;
use AppStoreServerLibrary\Models\Platform;
use AppStoreServerLibrary\Models\PlayTime;
use AppStoreServerLibrary\Models\SendAttemptItem;
use AppStoreServerLibrary\Models\SendAttemptResult;
use AppStoreServerLibrary\Models\Status;
use AppStoreServerLibrary\Models\SubscriptionGroupIdentifierItem;
use AppStoreServerLibrary\Models\Subtype;
use AppStoreServerLibrary\Models\TransactionHistoryRequest;
use AppStoreServerLibrary\Models\TransactionHistoryRequest\Order;
use AppStoreServerLibrary\Models\TransactionHistoryRequest\ProductType;
use AppStoreServerLibrary\Models\UserStatus;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\RequestOptions;
use PHPUnit\Framework\TestCase;

class AppStoreServerAPIClientTest extends TestCase
{
    const ISSUER_ID = "issuerId";
    const KEY_ID = "keyId";
    const BUNDLE_ID = "com.example";


    /**
     * @throws APIException
     */
    public function testExtendRenewalDateForAllActiveSubscribers(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/extendRenewalDateForAllActiveSubscribersResponse.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/subscriptions/extend/mass",
            expectedParams: [],
            expectedJson: [
                "extendByDays" => 45,
                "extendReasonCode" => 1,
                "requestIdentifier" => "fdf964a4-233b-486c-aac1-97d8d52688ac",
                "storefrontCountryCodes" => ["USA", "MEX"],
                "productId" => "com.example.productId"
            ]
        );

        $massExtendRenewalDateRequest = new MassExtendRenewalDateRequest(
            extendByDays: 45,
            extendReasonCode: ExtendReasonCode::CUSTOMER_SATISFACTION,
            requestIdentifier: "fdf964a4-233b-486c-aac1-97d8d52688ac",
            storefrontCountryCodes: ["USA", "MEX"],
            productId: "com.example.productId"
        );

        $massExtendRenewalDateResponse = $client->extendRenewalDateForAllActiveSubscribers(
            $massExtendRenewalDateRequest
        );

        self::assertEquals(
            "758883e8-151b-47b7-abd0-60c4d804c2f5",
            $massExtendRenewalDateResponse->getRequestIdentifier()
        );
    }

    /**
     * @throws APIException
     */
    public function testExtendSubscriptionRenewalDate(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/extendSubscriptionRenewalDateResponse.json",
            expectedMethod: "PUT",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/subscriptions/extend/4124214",
            expectedParams: [],
            expectedJson: [
                "extendByDays" => 45,
                "extendReasonCode" => 1,
                "requestIdentifier" => "fdf964a4-233b-486c-aac1-97d8d52688ac"
            ]
        );

        $extendRenewalDateRequest = new ExtendRenewalDateRequest(
            extendByDays: 45,
            extendReasonCode: ExtendReasonCode::CUSTOMER_SATISFACTION,
            requestIdentifier: "fdf964a4-233b-486c-aac1-97d8d52688ac"
        );

        $extendRenewalDateResponse = $client->extendSubscriptionRenewalDate(
            originalTransactionId: "4124214",
            extendRenewalDateRequest: $extendRenewalDateRequest
        );

        self::assertEquals("2312412", $extendRenewalDateResponse->getOriginalTransactionId());
        self::assertEquals("9993", $extendRenewalDateResponse->getWebOrderLineItemId());
        self::assertTrue($extendRenewalDateResponse->getSuccess());
        self::assertEquals(1698148900000, $extendRenewalDateResponse->getEffectiveDate());
    }

    /**
     * @throws APIException
     */
    public function testGetAllSubscriptionStatusesResponse(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/getAllSubscriptionStatusesResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/subscriptions/4321",
            expectedParams: [
                "status" => ["2", "1"]
            ],
            expectedJson: null
        );

        $statusResponse = $client->getAllSubscriptionStatuses(
            transactionId: "4321",
            status: [Status::EXPIRED, Status::ACTIVE]
        );

        self::assertEquals(Environment::LOCAL_TESTING, $statusResponse->getEnvironment());
        self::assertEquals("com.example", $statusResponse->getBundleId());
        self::assertEquals(5454545, $statusResponse->getAppAppleId());

        $expectedData = [
            new SubscriptionGroupIdentifierItem(
                subscriptionGroupIdentifier: "sub_group_one",
                lastTransactions: [
                    new LastTransactionsItem(
                        status: Status::ACTIVE,
                        originalTransactionId: "3749183",
                        signedTransactionInfo: "signed_transaction_one",
                        signedRenewalInfo: "signed_renewal_one"
                    ),
                    new LastTransactionsItem(
                        status: Status::REVOKED,
                        originalTransactionId: "5314314134",
                        signedTransactionInfo: "signed_transaction_two",
                        signedRenewalInfo: "signed_renewal_two"
                    )
                ]
            ),
            new SubscriptionGroupIdentifierItem(
                subscriptionGroupIdentifier: "sub_group_two",
                lastTransactions: [
                    new LastTransactionsItem(
                        status: Status::EXPIRED,
                        originalTransactionId: "3413453",
                        signedTransactionInfo: "signed_transaction_three",
                        signedRenewalInfo: "signed_renewal_three"
                    )
                ]
            )
        ];
        self::assertEquals($expectedData, $statusResponse->getData());
    }

    /**
     * @throws APIException
     */
    public function testGetRefundHistory(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/getRefundHistoryResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v2/refund/lookup/555555",
            expectedParams: [
                "revision" => ["revision_input"]
            ],
            expectedJson: null
        );

        $refundHistoryResponse = $client->getRefundHistory(
            transactionId: "555555",
            revision: "revision_input"
        );

        self::assertEquals(
            ["signed_transaction_one", "signed_transaction_two"],
            $refundHistoryResponse->getSignedTransactions()
        );
        self::assertEquals("revision_output", $refundHistoryResponse->getRevision());
        self::assertTrue($refundHistoryResponse->getHasMore());
    }

    /**
     * @throws APIException
     */
    public function testGetStatusOfSubscriptionRenewalDateExtensions(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/getStatusOfSubscriptionRenewalDateExtensionsResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/subscriptions/extend/mass/"
                . "20fba8a0-2b80-4a7d-a17f-85c1854727f8/com.example.product",
            expectedParams: [],
            expectedJson: null
        );

        $massExtendRenewalDateStatusResponse = $client->getStatusOfSubscriptionRenewalDateExtensions(
            requestIdentifier: "com.example.product",
            productId: "20fba8a0-2b80-4a7d-a17f-85c1854727f8"
        );

        self::assertEquals(
            "20fba8a0-2b80-4a7d-a17f-85c1854727f8",
            $massExtendRenewalDateStatusResponse->getRequestIdentifier()
        );
        self::assertTrue($massExtendRenewalDateStatusResponse->getComplete());
        self::assertEquals(1698148900000, $massExtendRenewalDateStatusResponse->getCompleteDate());
        self::assertEquals(30, $massExtendRenewalDateStatusResponse->getSucceededCount());
        self::assertEquals(2, $massExtendRenewalDateStatusResponse->getFailedCount());
    }

    /**
     * @throws APIException
     */
    public function testGetTestNotificationStatus(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/getTestNotificationStatusResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test/"
                . "8cd2974c-f905-492a-bf9a-b2f47c791d19",
            expectedParams: [],
            expectedJson: null
        );

        $testNotificationResponse = $client->getTestNotificationStatus(
            testNotificationToken: "8cd2974c-f905-492a-bf9a-b2f47c791d19"
        );

        self::assertEquals("signed_payload", $testNotificationResponse->getSignedPayload());
        $expectedSendAttempts = [
            new SendAttemptItem(attemptDate: 1698148900000, sendAttemptResult: SendAttemptResult::NO_RESPONSE),
            new SendAttemptItem(attemptDate: 1698148950000, sendAttemptResult: SendAttemptResult::SUCCESS),
        ];
        self::assertEquals($expectedSendAttempts, $testNotificationResponse->getSendAttempts());
    }

    /**
     * @throws APIException
     */
    public function testGetNotificationHistory(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/getNotificationHistoryResponse.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/history",
            expectedParams: [
                "paginationToken" => ["a036bc0e-52b8-4bee-82fc-8c24cb6715d6"]
            ],
            expectedJson: [
                "startDate" => 1698148900000,
                "endDate" => 1698148950000,
                "notificationType" => "SUBSCRIBED",
                "notificationSubtype" => "INITIAL_BUY",
                "transactionId" => "999733843",
                "onlyFailures" => true
            ]
        );

        $notificationHistoryRequest = new NotificationHistoryRequest(
            startDate: 1698148900000,
            endDate: 1698148950000,
            notificationType: NotificationTypeV2::SUBSCRIBED,
            notificationSubtype: Subtype::INITIAL_BUY,
            transactionId: "999733843",
            onlyFailures: true
        );

        $notificationHistoryResponse = $client->getNotificationHistory(
            paginationToken: "a036bc0e-52b8-4bee-82fc-8c24cb6715d6",
            notificationHistoryRequest: $notificationHistoryRequest
        );

        self::assertEquals("57715481-805a-4283-8499-1c19b5d6b20a", $notificationHistoryResponse->getPaginationToken());
        self::assertTrue($notificationHistoryResponse->getHasMore());
        $expectedNotificationHistory = [
            new NotificationHistoryResponseItem(signedPayload: "signed_payload_one", sendAttempts: [
                new SendAttemptItem(
                    attemptDate: 1698148900000,
                    sendAttemptResult: SendAttemptResult::NO_RESPONSE
                ),
                new SendAttemptItem(
                    attemptDate: 1698148950000,
                    sendAttemptResult: SendAttemptResult::SUCCESS
                )
            ]),
            new NotificationHistoryResponseItem(signedPayload: "signed_payload_two", sendAttempts: [
                new SendAttemptItem(
                    attemptDate: 1698148800000,
                    sendAttemptResult: SendAttemptResult::CIRCULAR_REDIRECT
                )
            ])
        ];
        self::assertEquals($expectedNotificationHistory, $notificationHistoryResponse->getNotificationHistory());
    }

    /**
     * @throws APIException
     */
    public function testGetTransactionHistory(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/transactionHistoryResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/history/1234",
            expectedParams: [
                "revision" => ["revision_input"],
                "startDate" => ["123455"],
                "endDate" => ["123456"],
                "productId" => ["com.example.1", "com.example.2"],
                "productType" => ["CONSUMABLE", "AUTO_RENEWABLE"],
                "sort" => ["ASCENDING"],
                "subscriptionGroupIdentifier" => ["sub_group_id", "sub_group_id_2"],
                "inAppOwnershipType" => ["FAMILY_SHARED"],
                "revoked" => ["false"],
            ],
            expectedJson: null
        );

        $transactionHistoryRequest = new TransactionHistoryRequest(
            startDate: 123455,
            endDate: 123456,
            productIds: ["com.example.1", "com.example.2"],
            productTypes: [ProductType::CONSUMABLE, ProductType::AUTO_RENEWABLE],
            sort: Order::ASCENDING,
            subscriptionGroupIdentifiers: ["sub_group_id", "sub_group_id_2"],
            inAppOwnershipType: InAppOwnershipType::FAMILY_SHARED,
            revoked: false
        );

        $transactionHistoryResponse = $client->getTransactionHistory(
            transactionId: "1234",
            revision: "revision_input",
            transactionHistoryRequest: $transactionHistoryRequest
        );

        self::assertEquals("revision_output", $transactionHistoryResponse->getRevision());
        self::assertTrue($transactionHistoryResponse->getHasMore());
        self::assertEquals("com.example", $transactionHistoryResponse->getBundleId());
        self::assertEquals(323232, $transactionHistoryResponse->getAppAppleId());
        self::assertEquals(Environment::LOCAL_TESTING, $transactionHistoryResponse->getEnvironment());
        self::assertEquals(
            ["signed_transaction_value", "signed_transaction_value2"],
            $transactionHistoryResponse->getSignedTransactions()
        );
    }

    /**
     * @throws APIException
     */
    public function testGetTransactionInfo(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/transactionInfoResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/transactions/1234",
            expectedParams: [],
            expectedJson: null
        );

        $transactionInfoResponse = $client->getTransactionInfo(
            transactionId: "1234"
        );

        self::assertEquals("signed_transaction_info_value", $transactionInfoResponse->getSignedTransactionInfo());
    }

    /**
     * @throws APIException
     */
    public function testLookUpOrderId(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/lookupOrderIdResponse.json",
            expectedMethod: "GET",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/lookup/W002182",
            expectedParams: [],
            expectedJson: null
        );

        $orderLookupResponse = $client->lookUpOrderId(
            orderId: "W002182"
        );

        self::assertEquals(OrderLookupStatus::INVALID, $orderLookupResponse->getStatus());
        self::assertEquals(
            ["signed_transaction_one", "signed_transaction_two"],
            $orderLookupResponse->getSignedTransactions()
        );
    }

    /**
     * @throws APIException
     */
    public function testRequestTestNotification(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/requestTestNotificationResponse.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test",
            expectedParams: [],
            expectedJson: null
        );

        $sendTestNotificationResponse = $client->requestTestNotification();

        self::assertEquals(
            "ce3af791-365e-4c60-841b-1674b43c1609",
            $sendTestNotificationResponse->getTestNotificationToken()
        );
    }

    /**
     * @throws APIException
     */
    public function testSendConsumptionData(): void
    {
        $client = $this->getClientWithBody(
            body: "",
            expectedMethod: "PUT",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/transactions/consumption/49571273",
            expectedParams: [],
            expectedJson: [
                "customerConsented" => true,
                "consumptionStatus" => 1,
                "platform" => 2,
                "sampleContentProvided" => false,
                "deliveryStatus" => 3,
                "appAccountToken" => "7389a31a-fb6d-4569-a2a6-db7d85d84813",
                "accountTenure" => 4,
                "playTime" => 5,
                "lifetimeDollarsRefunded" => 6,
                "lifetimeDollarsPurchased" => 7,
                "userStatus" => 4
            ]
        );

        $consumptionRequest = new ConsumptionRequest(
            customerConsented: true,
            consumptionStatus: ConsumptionStatus::NOT_CONSUMED,
            platform: Platform::NON_APPLE,
            sampleContentProvided: false,
            deliveryStatus: DeliveryStatus::DID_NOT_DELIVER_DUE_TO_SERVER_OUTAGE,
            appAccountToken: '7389a31a-fb6d-4569-a2a6-db7d85d84813',
            accountTenure: AccountTenure::THIRTY_DAYS_TO_NINETY_DAYS,
            playTime: PlayTime::ONE_DAY_TO_FOUR_DAYS,
            lifetimeDollarsRefunded: LifetimeDollarsRefunded::
                ONE_THOUSAND_DOLLARS_TO_ONE_THOUSAND_NINE_HUNDRED_NINETY_NINE_DOLLARS_AND_NINETY_NINE_CENTS,
            lifetimeDollarsPurchased: LifetimeDollarsPurchased::TWO_THOUSAND_DOLLARS_OR_GREATER,
            userStatus: UserStatus::LIMITED_ACCESS
        );

        $client->sendConsumptionData(
            transactionId: "49571273",
            consumptionRequest: $consumptionRequest
        );
    }

    public function testApiError(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/apiException.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test",
            expectedParams: [],
            expectedJson: null,
            statusCode: 500
        );

        try {
            $client->requestTestNotification();
        } catch (APIException $e) {
            self::assertEquals(500, $e->getHttpStatusCode());
            self::assertEquals(APIError::GENERAL_INTERNAL, $e->getApiError());
            return;
        }

        self::fail("Expected client to throw APIException.");
    }

    public function testApiTooManyRequests(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/apiTooManyRequestsException.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test",
            expectedParams: [],
            expectedJson: null,
            statusCode: 429
        );

        try {
            $client->requestTestNotification();
        } catch (APIException $e) {
            self::assertEquals(429, $e->getHttpStatusCode());
            self::assertEquals(APIError::RATE_LIMIT_EXCEEDED, $e->getApiError());
            return;
        }

        self::fail("Expected client to throw APIException.");
    }

    public function testUnknownError(): void
    {
        $client = $this->getClientWithBodyFromFile(
            path: __DIR__ . "/resources/models/apiUnknownError.json",
            expectedMethod: "POST",
            expectedUrl: "https://api.storekit-sandbox.itunes.apple.com/inApps/v1/notifications/test",
            expectedParams: [],
            expectedJson: null,
            statusCode: 400
        );

        try {
            $client->requestTestNotification();
        } catch (APIException $e) {
            self::assertEquals(400, $e->getHttpStatusCode());
            self::assertNull($e->getApiError());
            return;
        }

        self::fail("Expected client to throw APIException.");
    }

    private function getClientWithBody(
        string $body,
        string $expectedMethod,
        string $expectedUrl,
        array $expectedParams,
        ?array $expectedJson,
        int $statusCode = 200
    ): AppStoreServerAPIClient {
        $response = new Response(
            status: $statusCode,
            headers: ["Content-Type" => "application/json"],
            body: $body
        );

        $expectedQueryItems = [];
        foreach ($expectedParams as $key => $values) {
            foreach ($values as $value) {
                $expectedQueryItems[] = urlencode($key) . "=" . urlencode($value);
            }
        }

        $expectedUri = $expectedUrl;
        if (!empty($expectedParams)) {
            $expectedUri .= "?" . implode("&", $expectedQueryItems);
        }
        $clientMock = $this->createMock(Client::class);
        $clientMock
            ->expects($this->once())
            ->method("request")
            ->with(
                $this->equalTo($expectedMethod),
                $this->equalTo($expectedUri),
                $this->callback(function (array $options) use ($expectedJson) {
                    $headers = $options[RequestOptions::HEADERS] ?? null;
                    $json = $options[RequestOptions::JSON] ?? null;
                    if (!is_array($headers)
                        || ["User-Agent", "Authorization", "Accept"] !== array_keys($headers)
                        || "application/json" !== $headers["Accept"]
                        || AppStoreServerAPIClient::USER_AGENT !== $headers["User-Agent"]
                        || !str_starts_with($headers["Authorization"], "Bearer ")
                        || json_encode($expectedJson) !== json_encode($json)) {
                        return false;
                    }

                    [$headersBase64, $payloadBase64] = explode(".", substr($headers["Authorization"], 7));
                    $decodedJwt = [
                        "header" => json_decode(JWT::urlsafeB64Decode($headersBase64), associative: true),
                        "payload" => json_decode(JWT::urlsafeB64Decode($payloadBase64), associative: true)
                    ];
                    if (AppStoreServerAPIClient::APP_STORE_CONNECT_AUDIENCE !== $decodedJwt["payload"]["aud"] ?? null
                        || self::ISSUER_ID !== $decodedJwt["payload"]["iss"] ?? null
                        || self::KEY_ID !== $decodedJwt["header"]["kid"] ?? null
                        || self::BUNDLE_ID !== $decodedJwt["payload"]["bid"] ?? null
                    ) {
                        return false;
                    }

                    return true;
                })
            )
            ->will($this->returnValue($response));

        $signingKey = file_get_contents(__DIR__ . "/resources/certs/testSigningKey.p8");
        self::assertNotFalse($signingKey);
        return new AppStoreServerAPIClient(
            signingKey: $signingKey,
            keyId: self::KEY_ID,
            issuerId: self::ISSUER_ID,
            bundleId: self::BUNDLE_ID,
            environment: Environment::LOCAL_TESTING,
            client: $clientMock
        );
    }

    private function getClientWithBodyFromFile(
        string $path,
        string $expectedMethod,
        string $expectedUrl,
        ?array $expectedParams,
        ?array $expectedJson,
        int $statusCode = 200
    ): AppStoreServerAPIClient {
        $body = file_get_contents($path);
        return $this->getClientWithBody(
            body: $body,
            expectedMethod: $expectedMethod,
            expectedUrl: $expectedUrl,
            expectedParams: $expectedParams,
            expectedJson: $expectedJson,
            statusCode: $statusCode
        );
    }
}
