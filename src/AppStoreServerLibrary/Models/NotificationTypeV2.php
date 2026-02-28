<?php

namespace AppStoreServerLibrary\Models;

/**
 * The type that describes the in-app purchase or external purchase event for which the App Store sends the version 2
 * notification.
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
    case ONE_TIME_CHARGE = "ONE_TIME_CHARGE";
    case PRICE_INCREASE = "PRICE_INCREASE";
    case REFUND = "REFUND";
    case REFUND_DECLINED = "REFUND_DECLINED";
    case REFUND_REVERSED = "REFUND_REVERSED";
    case RENEWAL_EXTENDED = "RENEWAL_EXTENDED";
    case RENEWAL_EXTENSION = "RENEWAL_EXTENSION";
    case RESCIND_CONSENT = "RESCIND_CONSENT";
    case REVOKE = "REVOKE";
    case SUBSCRIBED = "SUBSCRIBED";
    case TEST = "TEST";
}
