<?php

namespace AppStoreServerLibrary\Models;

/**
 * The approval state of the message.
 *
 * https://developer.apple.com/documentation/retentionmessaging/messagestate
 */
enum MessageState: string
{
    case PENDING = "PENDING";
    case APPROVED = "APPROVED";
    case REJECTED = "REJECTED";
}
