<?php

namespace AppStoreServerLibrary\Models;

/**
 * The reason an auto-renewable subscription expired.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/expirationintent
 */
enum ExpirationIntent: int
{
    case CUSTOMER_CANCELLED = 1;
    case BILLING_ERROR = 2;
    case CUSTOMER_DID_NOT_CONSENT_TO_PRICE_INCREASE = 3;
    case PRODUCT_NOT_AVAILABLE = 4;
    case OTHER = 5;
}
