<?php

namespace AppStoreServerLibrary\Models;

/**
 * The customer-provided reason for a refund request.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/consumptionrequestreason
 */
enum ConsumptionRequestReason: string
{
    case UNINTENDED_PURCHASE = "UNINTENDED_PURCHASE";
    case FULFILLMENT_ISSUE = "FULFILLMENT_ISSUE";
    case UNSATISFIED_WITH_PURCHASE = "UNSATISFIED_WITH_PURCHASE";
    case LEGAL = "LEGAL";
    case OTHER = "OTHER";
}
