<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates the dollar amount of refunds the customer has received in your app, since purchasing the app,
 * across all platforms.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarsrefunded
 */
enum LifetimeDollarsRefunded: int
{
    case UNDECLARED = 0;
    case ZERO_DOLLARS = 1;
    case ONE_CENT_TO_FORTY_NINE_DOLLARS_AND_NINETY_NINE_CENTS = 2;
    case FIFTY_DOLLARS_TO_NINETY_NINE_DOLLARS_AND_NINETY_NINE_CENTS = 3;
    case ONE_HUNDRED_DOLLARS_TO_FOUR_HUNDRED_NINETY_NINE_DOLLARS_AND_NINETY_NINE_CENTS = 4;
    case FIVE_HUNDRED_DOLLARS_TO_NINE_HUNDRED_NINETY_NINE_DOLLARS_AND_NINETY_NINE_CENTS = 5;
    case ONE_THOUSAND_DOLLARS_TO_ONE_THOUSAND_NINE_HUNDRED_NINETY_NINE_DOLLARS_AND_NINETY_NINE_CENTS = 6;
    case TWO_THOUSAND_DOLLARS_OR_GREATER = 7;
}
