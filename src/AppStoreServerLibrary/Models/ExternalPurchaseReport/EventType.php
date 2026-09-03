<?php

namespace AppStoreServerLibrary\Models\ExternalPurchaseReport;

/**
 * The type of transaction the line item reports, whether it's a buy or refund.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/eventtype
 */
enum EventType: string
{
    case BUY = "BUY";
    case REFUND = "REFUND";
}
