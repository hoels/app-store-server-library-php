<?php

namespace AppStoreServerLibrary\Models;

/**
 * The status of a customer's account within your app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/userstatus
 */
enum UserStatus: int
{
    case UNDECLARED = 0;
    case ACTIVE = 1;
    case SUSPENDED = 2;
    case TERMINATED = 3;
    case LIMITED_ACCESS = 4;
}
