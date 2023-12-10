<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type of in-app purchase products you can offer in your app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/type
 */
enum Type: string
{
    case AUTO_RENEWABLE_SUBSCRIPTION = "Auto-Renewable Subscription";
    case NON_CONSUMABLE = "Non-Consumable";
    case CONSUMABLE = "Consumable";
    case NON_RENEWING_SUBSCRIPTION ="Non-Renewing Subscription";
}
