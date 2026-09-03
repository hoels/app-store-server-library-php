<?php

namespace AppStoreServerLibrary\Models\ExternalPurchaseReport;

/**
 * The type of product in the transaction, whether it's a one-time buy, or a subscription.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/producttype
 */
enum ProductType: string
{
    case ONE_TIME_BUY = "ONE_TIME_BUY";
    case SUBSCRIPTION = "SUBSCRIPTION";
}
