<?php

namespace AppStoreServerLibrary\Models;

/**
 * The platform on which the customer consumed the in-app purchase.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/platform
 */
enum Platform: int
{
    case UNDECLARED = 0;
    case APPLE = 1;
    case NON_APPLE = 2;
}
