<?php

namespace AppStoreServerLibrary\AppStoreServerAPIClient;

use Exception;

class APIException extends Exception
{
    private readonly int $httpStatusCode;
    private readonly ?APIError $apiError;
    private readonly ?string $errorMessage;

    public function __construct(
        int $httpStatusCode,
        ?int $rawApiError = null,
        ?string $errorMessage = null,
    ) {
        parent::__construct(message: $errorMessage ?? "", code: $httpStatusCode);
        $this->httpStatusCode = $httpStatusCode;
        $this->apiError = $rawApiError === null ? null : APIError::tryFrom($rawApiError);
        $this->errorMessage = $errorMessage;
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
}
