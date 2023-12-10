<?php

namespace AppStoreServerLibrary\AppStoreServerAPIClient;

use Exception;

class APIException extends Exception
{
    private readonly int $httpStatusCode;
    private readonly ?APIError $apiError;

    public function __construct(
        int $httpStatusCode,
        ?int $rawApiError = null,
    ) {
        parent::__construct(code: $httpStatusCode);
        $this->httpStatusCode = $httpStatusCode;
        $this->apiError = $rawApiError === null ? null : APIError::tryFrom($rawApiError);
    }

    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    public function getApiError(): ?APIError
    {
        return $this->apiError;
    }
}
