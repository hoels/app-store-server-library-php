<?php

namespace AppStoreServerLibrary\SignedDataVerifier;

enum VerificationStatus: int
{
    case OK = 0;
    case VERIFICATION_FAILURE = 1;
    case INVALID_APP_IDENTIFIER = 2;
    case INVALID_CERTIFICATE = 3;
    case INVALID_CHAIN_LENGTH = 4;
    case INVALID_CHAIN = 5;
    case INVALID_ENVIRONMENT = 6;
    case INVALID_JWT_FORMAT = 7;
}
