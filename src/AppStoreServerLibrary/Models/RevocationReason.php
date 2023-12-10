<?php

namespace AppStoreServerLibrary\Models;

/**
 * The reason for a refunded transaction.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/revocationreason
 */
enum RevocationReason: int
{
    case REFUNDED_DUE_TO_ISSUE = 1;
    case REFUNDED_FOR_OTHER_REASON = 0;
}
