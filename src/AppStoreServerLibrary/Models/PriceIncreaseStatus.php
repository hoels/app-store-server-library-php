<?php

namespace AppStoreServerLibrary\Models;

/**
 * The status that indicates whether an auto-renewable subscription is subject to a price increase.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/priceincreasestatus
 */
enum PriceIncreaseStatus: int
{
    case CUSTOMER_HAS_NOT_RESPONDED = 0;
    case CUSTOMER_CONSENTED_OR_WAS_NOTIFIED_WITHOUT_NEEDING_CONSENT = 1;
}
