<?php

namespace AppStoreServerLibrary\AppStoreServerAPIClient;

use Exception;

class APIException extends Exception
{
    private readonly int $httpStatusCode;
    private readonly ?APIError $apiError;
    private readonly ?string $errorMessage;
    /** @var string[][] */
    private readonly array $headers;
    private readonly ?int $retryAfter;

    /**
     * @param string[][] $headers
     */
    public function __construct(
        int $httpStatusCode,
        ?int $rawApiError = null,
        ?string $errorMessage = null,
        ?array $headers = null,
    ) {
        parent::__construct(message: $errorMessage ?? "", code: $httpStatusCode);
        $this->httpStatusCode = $httpStatusCode;
        $this->apiError = $rawApiError === null ? null : APIError::tryFrom($rawApiError);
        $this->errorMessage = $errorMessage;
        $this->headers = $headers ?? [];
        if (($retryAfter = $headers["Retry-After"][0] ?? null) !== null
            && preg_match("/^\d+$/", $retryAfter) === 1
        ) {
            $this->retryAfter = intval($retryAfter);
        } else {
            $this->retryAfter = null;
        }
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getApiError(): ?APIError
    {
        return $this->apiError;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * The response headers, keyed by lowercased header name.
     *
     * @return string[][]
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * A UNIX time, in milliseconds, that informs you when you can next send a request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/identifying-rate-limits
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }
}
