<?php

namespace AppStoreServerLibrary\Models;

/**
 * The size of an image.
 *
 * https://developer.apple.com/documentation/retentionmessaging/imagesize
 */
enum ImageSize: string
{
    case FULL_SIZE = "FULL_SIZE";
    case BULLET_POINT = "BULLET_POINT";
}
