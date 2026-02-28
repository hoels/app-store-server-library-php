<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates whether the app successfully delivered an In-App Purchase that works properly.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/deliverystatus
 */
enum DeliveryStatus: string
{
    case DELIVERED = "DELIVERED";
    case UNDELIVERED_QUALITY_ISSUE = "UNDELIVERED_QUALITY_ISSUE";
    case UNDELIVERED_WRONG_ITEM = "UNDELIVERED_WRONG_ITEM";
    case UNDELIVERED_SERVER_OUTAGE = "UNDELIVERED_SERVER_OUTAGE";
    case UNDELIVERED_OTHER = "UNDELIVERED_OTHER";
}
