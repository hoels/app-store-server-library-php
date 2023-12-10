<?php

namespace AppStoreServerLibrary\Models;

/**
 * A value that indicates the amount of time that the customer used the app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/playtime
 */
enum PlayTime: int
{
    case UNDECLARED = 0;
    case ZERO_TO_FIVE_MINUTES = 1;
    case FIVE_TO_SIXTY_MINUTES = 2;
    case ONE_TO_SIX_HOURS = 3;
    case SIX_HOURS_TO_TWENTY_FOUR_HOURS = 4;
    case ONE_DAY_TO_FOUR_DAYS = 5;
    case FOUR_DAYS_TO_SIXTEEN_DAYS = 6;
    case OVER_SIXTEEN_DAYS = 7;
}
