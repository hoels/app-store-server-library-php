<?php

namespace AppStoreServerLibrary\SignedDataVerifier;

use Exception;

class VerificationException extends Exception
{
    public function __construct(private readonly VerificationStatus $status)
    {
        parent::__construct(
            message: "Verification failed with status $status->name",
            code: $status->value
        );
    }

    public function getStatus(): VerificationStatus
    {
        return $this->status;
    }
}
