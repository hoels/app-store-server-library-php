<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates the extent to which the customer consumed the in-app purchase.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/consumptionstatus
 */
enum ConsumptionStatus: int
{
    case UNDECLARED = 0;
    case NOT_CONSUMED = 1;
    case PARTIALLY_CONSUMED = 2;
    case FULLY_CONSUMED = 3;
}
