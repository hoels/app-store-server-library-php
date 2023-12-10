<?php

namespace AppStoreServerLibrary\Models;

/**
 * The payment mode you configure for an introductory offer, promotional offer, or offer code on an auto-renewable
 * subscription.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/offerdiscounttype
 */
enum OfferDiscountType: string
{
    case FREE_TRIAL = "FREE_TRIAL";
    case PAY_AS_YOU_GO = "PAY_AS_YOU_GO";
    case PAY_UP_FRONT = "PAY_UP_FRONT";
}
