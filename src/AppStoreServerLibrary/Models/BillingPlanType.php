<?php

namespace AppStoreServerLibrary\Models;

/**
 * https://developer.apple.com/documentation/appstoreserverapi/billingplantype
 */
enum BillingPlanType: string
{
    case BILLED_UPFRONT = "BILLED_UPFRONT";
    case MONTHLY = "MONTHLY";
}
