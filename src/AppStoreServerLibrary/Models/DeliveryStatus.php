<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates whether the app successfully delivered an in-app purchase that works properly.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/deliverystatus
 */
enum DeliveryStatus: int
{
    case DELIVERED_AND_WORKING_PROPERLY = 0;
    case DID_NOT_DELIVER_DUE_TO_QUALITY_ISSUE = 1;
    case DELIVERED_WRONG_ITEM = 2;
    case DID_NOT_DELIVER_DUE_TO_SERVER_OUTAGE = 3;
    case DID_NOT_DELIVER_DUE_TO_IN_GAME_CURRENCY_CHANGE = 4;
    case DID_NOT_DELIVER_FOR_OTHER_REASON = 5;
}
