<?php

namespace AppStoreServerLibrary\Models;

/**
 * The position where the header text appears in a message.
 *
 * https://developer.apple.com/documentation/retentionmessaging/headerposition
 */
enum HeaderPosition: string
{
    case ABOVE_BODY = "ABOVE_BODY";
    case ABOVE_IMAGE = "ABOVE_IMAGE";
}
