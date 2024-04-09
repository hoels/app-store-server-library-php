<?php

namespace AppStoreServerLibrary\Models;

/**
 * The server environment, either sandbox or production.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/environment
 */
enum Environment: string
{
    case SANDBOX = "Sandbox";
    case PRODUCTION = "Production";
    case XCODE = "Xcode";
    case LOCAL_TESTING = "LocalTesting"; // Used for unit testing
}
