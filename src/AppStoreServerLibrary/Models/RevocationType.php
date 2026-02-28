<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type of the refund or revocation that applies to the transaction.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/revocationtype
 */
enum RevocationType: string
{
    case REFUND_FULL = "REFUND_FULL";
    case REFUND_PRORATED = "REFUND_PRORATED";
    case FAMILY_REVOKE = "FAMILY_REVOKE";
}
