<?php

namespace AppStoreServerLibrary\Models;

/**
 * The status of an auto-renewable subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/status
 */
enum Status: int
{
    case ACTIVE = 1;
    case EXPIRED = 2;
    case BILLING_RETRY = 3;
    case BILLING_GRACE_PERIOD = 4;
    case REVOKED = 5;
}
