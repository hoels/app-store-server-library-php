<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates your preferred outcome for the refund request.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/refundpreference
 */
enum RefundPreference: int
{
    case UNDECLARED = 0;
    case PREFER_GRANT = 1;
    case PREFER_DECLINE = 2;
    case NO_PREFERENCE = 3;
}
