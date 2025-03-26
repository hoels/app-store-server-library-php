<?php

namespace AppStoreServerLibrary\Models;

/**
 * Values that represent Apple platforms.
 *
 * https://developer.apple.com/documentation/storekit/appstore/platform
 */
enum PurchasePlatform: string
{
    case IOS = "iOS";
    case MAC_OS = "macOS";
    case TV_OS = "tvOS";
    case VISION_OS = "visionOS";
}
