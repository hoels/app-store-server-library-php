<?php

namespace AppStoreServerLibrary\Models;

/**
 * The success or error information the App Store server records when it attempts to send an App Store server
 * notification to your server.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/sendattemptresult
 */
enum SendAttemptResult: string
{
    case SUCCESS = "SUCCESS";
    case TIMED_OUT = "TIMED_OUT";
    case TLS_ISSUE = "TLS_ISSUE";
    case CIRCULAR_REDIRECT = "CIRCULAR_REDIRECT";
    case NO_RESPONSE = "NO_RESPONSE";
    case SOCKET_ISSUE = "SOCKET_ISSUE";
    case UNSUPPORTED_CHARSET = "UNSUPPORTED_CHARSET";
    case INVALID_RESPONSE = "INVALID_RESPONSE";
    case PREMATURE_CLOSE = "PREMATURE_CLOSE";
    case UNSUCCESSFUL_HTTP_RESPONSE_CODE = "UNSUCCESSFUL_HTTP_RESPONSE_CODE";
    case OTHER = "OTHER";
}
