<?php

namespace AppStoreServerLibrary;

use AppStoreServerLibrary\AppStoreServerAPIClient\APIException;
use AppStoreServerLibrary\Models\CheckTestNotificationResponse;
use AppStoreServerLibrary\Models\ConsumptionRequest;
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\Models\ExtendRenewalDateRequest;
use AppStoreServerLibrary\Models\ExtendRenewalDateResponse;
use AppStoreServerLibrary\Models\HistoryResponse;
use AppStoreServerLibrary\Models\MassExtendRenewalDateRequest;
use AppStoreServerLibrary\Models\MassExtendRenewalDateResponse;
use AppStoreServerLibrary\Models\MassExtendRenewalDateStatusResponse;
use AppStoreServerLibrary\Models\NotificationHistoryRequest;
use AppStoreServerLibrary\Models\NotificationHistoryResponse;
use AppStoreServerLibrary\Models\OrderLookupResponse;
use AppStoreServerLibrary\Models\RefundHistoryResponse;
use AppStoreServerLibrary\Models\SendTestNotificationResponse;
use AppStoreServerLibrary\Models\Status;
use AppStoreServerLibrary\Models\StatusResponse;
use AppStoreServerLibrary\Models\TransactionHistoryRequest;
use AppStoreServerLibrary\Models\TransactionInfoResponse;
use Firebase\JWT\JWT;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\RequestOptions;
use JsonSerializable;
use ValueError;

class AppStoreServerAPIClient
{
    const USER_AGENT = "app-store-server-library/php/1.1.0";
    const PRODUCTION_URL = "https://api.storekit.itunes.apple.com";
    const LOCAL_TESTING_URL = "https://local-testing-base-url";
    const SANDBOX_URL = "https://api.storekit-sandbox.itunes.apple.com";
    const APP_STORE_CONNECT_AUDIENCE = "appstoreconnect-v1";


    private readonly Client $client;
    private readonly string $baseUrl;


    public function __construct(
        private readonly string $signingKey,
        private readonly string $keyId,
        private readonly string $issuerId,
        private readonly string $bundleId,
        Environment $environment,
        ?Client $client = null,
    ) {
        if ($environment === Environment::XCODE) {
            throw new ValueError("Xcode is not a supported environment for an AppStoreServerAPIClient");
        } elseif ($environment === Environment::PRODUCTION) {
            $this->baseUrl = self::PRODUCTION_URL;
        } elseif ($environment === Environment::LOCAL_TESTING) {
            $this->baseUrl = self::LOCAL_TESTING_URL;
        } else {
            $this->baseUrl = self::SANDBOX_URL;
        }
        $this->client = $client ?? new Client([
            RequestOptions::TIMEOUT => 30,
            RequestOptions::CONNECT_TIMEOUT => 30,
            RequestOptions::HTTP_ERRORS => false,
        ]);
    }

    private function generateToken(): string
    {
        return JWT::encode(
            payload: [
                "bid" => $this->bundleId,
                "iss" => $this->issuerId,
                "aud" => self::APP_STORE_CONNECT_AUDIENCE,
                "iat" => time(),
                "exp" => time() + 300,
            ],
            key: $this->signingKey,
            alg: "ES256",
            keyId: $this->keyId
        );
    }

    /**
     * @param array<string, string[]> $queryParameters
     * @return mixed[]
     * @throws APIException
     */
    private function makeRequest(string $path, string $method, array $queryParameters, ?JsonSerializable $body): array
    {
        $headers = [
            "User-Agent" => self::USER_AGENT,
            "Authorization" => "Bearer " . $this->generateToken(),
            "Accept" => "application/json",
        ];

        $options = [RequestOptions::HEADERS => $headers];
        if ($body !== null) {
            $options[RequestOptions::JSON] = $body->jsonSerialize();
        }

        $queryItems = [];
        foreach ($queryParameters as $key => $values) {
            foreach ($values as $value) {
                $queryItems[] = urlencode($key) . "=" . urlencode($value);
            }
        }

        $uri = $this->baseUrl . $path;
        if (!empty($queryItems)) {
            $uri .= "?" . implode("&", $queryItems);
        }

        try {
            $response = $this->client->request(
                method: $method,
                uri: $uri,
                options: $options
            );
        } catch (GuzzleException) {
            // may occur when no connection can be established
            throw new APIException(httpStatusCode: 0);
        }

        if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
            $responseBody = json_decode((string)$response->getBody(), true);
            return is_array($responseBody) ? $responseBody : [];
        } else {
            if ($response->getHeaderLine("Content-Type") !== "application/json") {
                throw new APIException(httpStatusCode: $response->getStatusCode());
            }
            $responseBody = json_decode((string)$response->getBody(), true);
            $responseBody = is_array($responseBody) ? $responseBody : [];
            $rawApiError = is_int($responseBody["errorCode"] ?? null) ? $responseBody["errorCode"] : null;
            $errorMessage = is_string($responseBody["errorMessage"] ?? null)
                ? $responseBody["errorMessage"] : null;
            throw new APIException(
                httpStatusCode: $response->getStatusCode(),
                rawApiError: $rawApiError,
                errorMessage: $errorMessage
            );
        }
    }

    /**
     * Uses a subscription's product identifier to extend the renewal date for all of its eligible active subscribers.
     * https://developer.apple.com/documentation/appstoreserverapi/extend_subscription_renewal_dates_for_all_active_subscribers
     *
     * @param MassExtendRenewalDateRequest $massExtendRenewalDateRequest The request body for extending a subscription
     * renewal date for all of its active subscribers.
     * @return MassExtendRenewalDateResponse A response that indicates the server successfully received the
     * subscription-renewal-date extension request.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function extendRenewalDateForAllActiveSubscribers(
        MassExtendRenewalDateRequest $massExtendRenewalDateRequest
    ): MassExtendRenewalDateResponse {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/subscriptions/extend/mass",
            method: "POST",
            queryParameters: [],
            body: $massExtendRenewalDateRequest
        );
        return MassExtendRenewalDateResponse::fromObject((object)$responseBody);
    }

    /**
     * Extends the renewal date of a customer's active subscription using the original transaction identifier.
     * https://developer.apple.com/documentation/appstoreserverapi/extend_a_subscription_renewal_date
     *
     * @param string $originalTransactionId The original transaction identifier of the subscription receiving a renewal
     * date extension.
     * @param ExtendRenewalDateRequest $extendRenewalDateRequest The request body containing
     * subscription-renewal-extension data.
     * @return ExtendRenewalDateResponse A response that indicates whether an individual renewal-date extension
     * succeeded, and related details.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function extendSubscriptionRenewalDate(
        string $originalTransactionId,
        ExtendRenewalDateRequest $extendRenewalDateRequest
    ): ExtendRenewalDateResponse {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/subscriptions/extend/" . $originalTransactionId,
            method: "PUT",
            queryParameters: [],
            body: $extendRenewalDateRequest
        );
        return ExtendRenewalDateResponse::fromObject((object)$responseBody);
    }

    /**
     * Get the statuses for all of a customer's auto-renewable subscriptions in your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_all_subscription_statuses
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer, and which may be an
     * original transaction identifier.
     * @param Status[]|null $status An optional filter that indicates the status of subscriptions to include in the
     * response. Your query may specify more than one status query parameter.
     * @return StatusResponse A response that contains status information for all of a customer's auto-renewable
     * subscriptions in your app.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getAllSubscriptionStatuses(string $transactionId, ?array $status = null): StatusResponse
    {
        $queryParameters = [];
        if ($status !== null) {
            $queryParameters["status"] = array_map(fn ($s) => "" . $s->value, $status);
        }

        $responseBody = $this->makeRequest(
            path: "/inApps/v1/subscriptions/" . $transactionId,
            method: "GET",
            queryParameters: $queryParameters,
            body: null
        );
        return StatusResponse::fromObject((object)$responseBody);
    }

    /**
     * Get a paginated list of all of a customer's refunded in-app purchases for your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_refund_history
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer, and which may be an
     * original transaction identifier.
     * @param string|null $revision A token you provide to get the next set of up to 20 transactions. All responses
     * include a revision token. Use the revision token from the previous RefundHistoryResponse.
     * @return RefundHistoryResponse A response that contains status information for all of a customer's auto-renewable
     * subscriptions in your app.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getRefundHistory(string $transactionId, ?string $revision = null): RefundHistoryResponse
    {
        $queryParameters = [];
        if ($revision !== null) {
            $queryParameters["revision"] = [$revision];
        }

        $responseBody = $this->makeRequest(
            path: "/inApps/v2/refund/lookup/" . $transactionId,
            method: "GET",
            queryParameters: $queryParameters,
            body: null
        );
        return RefundHistoryResponse::fromObject((object)$responseBody);
    }

    /**
     * Checks whether a renewal date extension request completed, and provides the final count of successful or failed
     * extensions.
     * https://developer.apple.com/documentation/appstoreserverapi/get_status_of_subscription_renewal_date_extensions
     *
     * @param string $requestIdentifier The UUID that represents your request to the Extend Subscription Renewal Dates
     * for All Active Subscribers endpoint.
     * @param string $productId The product identifier of the auto-renewable subscription that you request a
     * renewal-date extension for.
     * @return MassExtendRenewalDateStatusResponse A response that indicates the current status of a request to extend
     * the subscription renewal date to all eligible subscribers.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getStatusOfSubscriptionRenewalDateExtensions(
        string $requestIdentifier,
        string $productId
    ): MassExtendRenewalDateStatusResponse {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/subscriptions/extend/mass/" . $productId . "/" . $requestIdentifier,
            method: "GET",
            queryParameters: [],
            body: null
        );
        return MassExtendRenewalDateStatusResponse::fromObject((object)$responseBody);
    }

    /**
     * Check the status of the test App Store server notification sent to your server.
     * https://developer.apple.com/documentation/appstoreserverapi/get_test_notification_status
     *
     * @param string $testNotificationToken The test notification token received from the Request a Test Notification
     * endpoint
     * @return CheckTestNotificationResponse A response that contains the contents of the test notification sent by the
     * App Store server and the result from your server.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getTestNotificationStatus(string $testNotificationToken): CheckTestNotificationResponse
    {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/notifications/test/" . $testNotificationToken,
            method: "GET",
            queryParameters: [],
            body: null
        );
        return CheckTestNotificationResponse::fromObject((object)$responseBody);
    }

    /**
     * Get a list of notifications that the App Store server attempted to send to your server.
     * https://developer.apple.com/documentation/appstoreserverapi/get_notification_history
     *
     * @param string|null $paginationToken An optional token you use to get the next set of up to 20 notification
     * history records. All responses that have more records available include a paginationToken. Omit this parameter
     * the first time you call this endpoint.
     * @param NotificationHistoryRequest $notificationHistoryRequest The request body that includes the start and end
     * dates, and optional query constraints.
     * @return NotificationHistoryResponse A response that contains the App Store Server Notifications history for your
     * app.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getNotificationHistory(
        ?string $paginationToken,
        NotificationHistoryRequest $notificationHistoryRequest
    ): NotificationHistoryResponse {
        $queryParameters = [];
        if ($paginationToken !== null) {
            $queryParameters["paginationToken"] = [$paginationToken];
        }

        $responseBody = $this->makeRequest(
            path: "/inApps/v1/notifications/history",
            method: "POST",
            queryParameters: $queryParameters,
            body: $notificationHistoryRequest
        );
        return NotificationHistoryResponse::fromObject((object)$responseBody);
    }

    /**
     * Get a customer's in-app purchase transaction history for your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_transaction_history
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer, and which may be an
     * original transaction identifier.
     * @param string|null $revision A token you provide to get the next set of up to 20 transactions. All responses
     * include a revision token. Note: For requests that use the revision token, include the same query parameters from
     * the initial request. Use the revision token from the previous HistoryResponse.
     * @param TransactionHistoryRequest|null $transactionHistoryRequest Optional additional request parameters,
     * including the startDate, endDate, productIds, and productTypes.
     * @return HistoryResponse A response that contains the customer's transaction history for an app.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getTransactionHistory(
        string $transactionId,
        ?string $revision = null,
        ?TransactionHistoryRequest $transactionHistoryRequest = null
    ): HistoryResponse {
        $queryParameters = [];
        if ($revision !== null) {
            $queryParameters["revision"] = [$revision];
        }
        if ($transactionHistoryRequest?->getStartDate() !== null) {
            $queryParameters["startDate"] = ["" . $transactionHistoryRequest?->getStartDate()];
        }
        if ($transactionHistoryRequest?->getEndDate() !== null) {
            $queryParameters["endDate"] = ["" . $transactionHistoryRequest?->getEndDate()];
        }
        if ($transactionHistoryRequest?->getProductIds() !== null) {
            $queryParameters["productId"] = $transactionHistoryRequest?->getProductIds();
        }
        if ($transactionHistoryRequest?->getProductTypes() !== null) {
            $queryParameters["productType"] = array_map(
                fn ($productType) => $productType->value,
                $transactionHistoryRequest?->getProductTypes()
            );
        }
        if ($transactionHistoryRequest?->getSort() !== null) {
            $queryParameters["sort"] = [$transactionHistoryRequest?->getSort()->value];
        }
        if ($transactionHistoryRequest?->getSubscriptionGroupIdentifiers() !== null) {
            $queryParameters["subscriptionGroupIdentifier"] = $transactionHistoryRequest
                ->getSubscriptionGroupIdentifiers();
        }
        if ($transactionHistoryRequest?->getInAppOwnershipType() !== null) {
            $queryParameters["inAppOwnershipType"] = [$transactionHistoryRequest?->getInAppOwnershipType()->value];
        }
        if ($transactionHistoryRequest?->getRevoked() !== null) {
            $queryParameters["revoked"] = [$transactionHistoryRequest?->getRevoked() ? "true" : "false"];
        }

        $responseBody = $this->makeRequest(
            path: "/inApps/v1/history/" . $transactionId,
            method: "GET",
            queryParameters: $queryParameters,
            body: null
        );
        return HistoryResponse::fromObject((object)$responseBody);
    }

    /**
     * Get information about a single transaction for your app.
     * https://developer.apple.com/documentation/appstoreserverapi/get_transaction_info
     *
     * @param string $transactionId The identifier of a transaction that belongs to the customer, and which may be an
     * original transaction identifier.
     * @return TransactionInfoResponse A response that contains signed transaction information for a single transaction.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function getTransactionInfo(string $transactionId): TransactionInfoResponse
    {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/transactions/" . $transactionId,
            method: "GET",
            queryParameters: [],
            body: null
        );
        return TransactionInfoResponse::fromObject((object)$responseBody);
    }

    /**
     * Get a customer's in-app purchases from a receipt using the order ID.
     * https://developer.apple.com/documentation/appstoreserverapi/look_up_order_id
     *
     * @param string $orderId The order ID for in-app purchases that belong to the customer.
     * @return OrderLookupResponse A response that includes the order lookup status and an array of signed transactions
     * for the in-app purchases in the order.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function lookUpOrderId(string $orderId): OrderLookupResponse
    {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/lookup/" . $orderId,
            method: "GET",
            queryParameters: [],
            body: null
        );
        return OrderLookupResponse::fromObject((object)$responseBody);
    }

    /**
     * Ask App Store Server Notifications to send a test notification to your server.
     * https://developer.apple.com/documentation/appstoreserverapi/request_a_test_notification
     *
     * @return SendTestNotificationResponse A response that contains the test notification token.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function requestTestNotification(): SendTestNotificationResponse
    {
        $responseBody = $this->makeRequest(
            path: "/inApps/v1/notifications/test",
            method: "POST",
            queryParameters: [],
            body: null
        );
        return SendTestNotificationResponse::fromObject((object)$responseBody);
    }

    /**
     * Send consumption information about a consumable in-app purchase to the App Store after your server receives a
     * consumption request notification.
     * https://developer.apple.com/documentation/appstoreserverapi/send_consumption_information
     *
     * @param string $transactionId The transaction identifier for which you're providing consumption information. You
     * receive this identifier in the CONSUMPTION_REQUEST notification the App Store sends to your server.
     * @param ConsumptionRequest $consumptionRequest The request body containing consumption information.
     * @throws APIException If a response was returned indicating the request could not be processed
     */
    public function sendConsumptionData(string $transactionId, ConsumptionRequest $consumptionRequest): void
    {
        $this->makeRequest(
            path: "/inApps/v1/transactions/consumption/" . $transactionId,
            method: "PUT",
            queryParameters: [],
            body: $consumptionRequest
        );
    }
}
