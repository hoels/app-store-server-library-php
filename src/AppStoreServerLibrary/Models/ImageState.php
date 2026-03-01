<?php

namespace AppStoreServerLibrary\Models;

/**
 * The approval state of an image.
 *
 * https://developer.apple.com/documentation/retentionmessaging/imagestate
 */
enum ImageState: string
{
    case PENDING = "PENDING";
    case APPROVED = "APPROVED";
    case REJECTED = "REJECTED";
}
