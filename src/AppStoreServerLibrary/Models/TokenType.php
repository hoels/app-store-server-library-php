<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type of an external purchase custom link token.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/tokentype
 */
enum TokenType: string
{
    case SERVICES = "SERVICES";
    case ACQUISITION = "ACQUISITION";
}
