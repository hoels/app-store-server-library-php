<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates whether the order ID in the request is valid for your app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/orderlookupstatus
 */
enum OrderLookupStatus: int
{
    case VALID = 0;
    case INVALID = 1;
}
