<?php

namespace AppStoreServerLibrary\Models;

/**
 * The code that represents the reason for the subscription-renewal-date extension.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/extendreasoncode
 */
enum ExtendReasonCode: int
{
    case UNDECLARED = 0;
    case CUSTOMER_SATISFACTION = 1;
    case OTHER = 2;
    case SERVICE_ISSUE_OR_OUTAGE = 3;
}
