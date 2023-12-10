<?php

namespace AppStoreServerLibrary\Models;

/**
 * The age of the customer's account.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/accounttenure
 */
enum AccountTenure: int
{
    case UNDECLARED = 0;
    case ZERO_TO_THREE_DAYS = 1;
    case THREE_DAYS_TO_TEN_DAYS = 2;
    case TEN_DAYS_TO_THIRTY_DAYS = 3;
    case THIRTY_DAYS_TO_NINETY_DAYS = 4;
    case NINETY_DAYS_TO_ONE_HUNDRED_EIGHTY_DAYS = 5;
    case ONE_HUNDRED_EIGHTY_DAYS_TO_THREE_HUNDRED_SIXTY_FIVE_DAYS = 6;
    case GREATER_THAN_THREE_HUNDRED_SIXTY_FIVE_DAYS = 7;
}
