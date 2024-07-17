<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type of subscription offer.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/offertype
 */
enum OfferType: int
{
    case INTRODUCTORY_OFFER = 1;
    case PROMOTIONAL_OFFER = 2;
    case SUBSCRIPTION_OFFER_CODE = 3;
    case WIN_BACK_OFFER = 4;
}
