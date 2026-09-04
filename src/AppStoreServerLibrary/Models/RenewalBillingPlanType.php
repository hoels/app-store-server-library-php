<?php

namespace AppStoreServerLibrary\Models;

/**
 * https://developer.apple.com/documentation/appstoreserverapi/renewalbillingplantype
 */
enum RenewalBillingPlanType: string
{
    case BILLED_UPFRONT = "BILLED_UPFRONT";
    case MONTHLY = "MONTHLY";
}
