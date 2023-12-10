<?php

namespace AppStoreServerLibrary\Models;

/**
 * The renewal status for an auto-renewable subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/autorenewstatus
 */
enum AutoRenewStatus: int
{
    case OFF = 0;
    case ON = 1;
}
