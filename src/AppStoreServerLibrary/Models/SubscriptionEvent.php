<?php

namespace AppStoreServerLibrary\Models;

/**
 * The event in the subscription’s life cycle that the transaction represents.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/subscriptionevent
 */
enum SubscriptionEvent: string
{
    case SUBSCRIPTION_START = "SUBSCRIPTION_START";
    case RENEWAL = "RENEWAL";
    case SUBSCRIPTION_CHANGE = "SUBSCRIPTION_CHANGE";
    case SUBSCRIPTION_PAYMENT = "SUBSCRIPTION_PAYMENT";
}
