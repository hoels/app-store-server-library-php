<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates your preferred outcome for the refund request.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/refundpreference
 */
enum RefundPreference: string
{
    case DECLINE = "DECLINE";
    case GRANT_FULL = "GRANT_FULL";
    case GRANT_PRORATED = "GRANT_PRORATED";
}
