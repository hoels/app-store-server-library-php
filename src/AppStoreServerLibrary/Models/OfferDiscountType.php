<?php

namespace AppStoreServerLibrary\Models;

/**
 * The payment mode for a discount offer on an In-App Purchase.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
 */
enum OfferDiscountType: string
{
    case FREE_TRIAL = "FREE_TRIAL";
    case PAY_AS_YOU_GO = "PAY_AS_YOU_GO";
    case PAY_UP_FRONT = "PAY_UP_FRONT";
    case ONE_TIME = "ONE_TIME";
}
