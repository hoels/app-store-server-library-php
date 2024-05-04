<?php

namespace AppStoreServerLibrary\Models;

/**
 * A notification type value that App Store Server Notifications V2 uses.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
 */
enum NotificationTypeV2: string
{
    case CONSUMPTION_REQUEST = "CONSUMPTION_REQUEST";
    case DID_CHANGE_RENEWAL_PREF = "DID_CHANGE_RENEWAL_PREF";
    case DID_CHANGE_RENEWAL_STATUS = "DID_CHANGE_RENEWAL_STATUS";
    case DID_FAIL_TO_RENEW = "DID_FAIL_TO_RENEW";
    case DID_RENEW = "DID_RENEW";
    case EXPIRED = "EXPIRED";
    case EXTERNAL_PURCHASE_TOKEN = "EXTERNAL_PURCHASE_TOKEN";
    case GRACE_PERIOD_EXPIRED = "GRACE_PERIOD_EXPIRED";
    case OFFER_REDEEMED = "OFFER_REDEEMED";
    case PRICE_INCREASE = "PRICE_INCREASE";
    case REFUND = "REFUND";
    case REFUND_DECLINED = "REFUND_DECLINED";
    case REFUND_REVERSED = "REFUND_REVERSED";
    case RENEWAL_EXTENDED = "RENEWAL_EXTENDED";
    case RENEWAL_EXTENSION = "RENEWAL_EXTENSION";
    case REVOKE = "REVOKE";
    case SUBSCRIBED = "SUBSCRIBED";
    case TEST = "TEST";
}
