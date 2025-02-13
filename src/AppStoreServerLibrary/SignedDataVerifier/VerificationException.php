<?php

namespace AppStoreServerLibrary\SignedDataVerifier;

use Exception;

class VerificationException extends Exception
{
    public function __construct(
        private readonly VerificationStatus $status,
        private readonly bool $isPermanentFailure = true,
    ) {
        parent::__construct(
            message: "Verification failed with status " . $status->name,
            code: $status->value
        );
    }

    public function getStatus(): VerificationStatus
    {
        return $this->status;
    }

    public function isPermanentFailure(): bool
    {
        return $this->isPermanentFailure;
    }
}
