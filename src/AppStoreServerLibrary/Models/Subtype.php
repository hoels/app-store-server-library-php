<?php

namespace AppStoreServerLibrary\Models;

/**
 * A string that provides details about select notification types in version 2.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/subtype
 */
enum Subtype: string
{
    case ACCEPTED = "ACCEPTED";
    case AUTO_RENEW_DISABLED = "AUTO_RENEW_DISABLED";
    case AUTO_RENEW_ENABLED = "AUTO_RENEW_ENABLED";
    case BILLING_RECOVERY = "BILLING_RECOVERY";
    case BILLING_RETRY = "BILLING_RETRY";
    case DOWNGRADE = "DOWNGRADE";
    case FAILURE = "FAILURE";
    case GRACE_PERIOD = "GRACE_PERIOD";
    case INITIAL_BUY = "INITIAL_BUY";
    case PENDING = "PENDING";
    case PRICE_INCREASE = "PRICE_INCREASE";
    case PRODUCT_NOT_FOR_SALE = "PRODUCT_NOT_FOR_SALE";
    case RESUBSCRIBE = "RESUBSCRIBE";
    case SUMMARY = "SUMMARY";
    case UNREPORTED = "UNREPORTED";
    case UPGRADE = "UPGRADE";
    case VOLUNTARY = "VOLUNTARY";
}
