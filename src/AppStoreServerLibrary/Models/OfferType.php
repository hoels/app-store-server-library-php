<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type of offer.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/offertype
 */
enum OfferType: int
{
    case INTRODUCTORY_OFFER = 1;
    case PROMOTIONAL_OFFER = 2;
    case OFFER_CODE = 3;
    case WIN_BACK_OFFER = 4;
}
