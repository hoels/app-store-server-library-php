<?php

namespace AppStoreServerLibrary\Models;

/**
 * A string value you provide to indicate the status of the token and the contents of the external purchase report.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/status
 */
enum ExternalPurchaseStatus: string
{
    case LINE_ITEM = "LINE_ITEM";
    case NO_LINE_ITEM = "NO_LINE_ITEM";
    case UNRECOGNIZED_TOKEN = "UNRECOGNIZED_TOKEN";
    case DUPLICATE_TOKEN = "DUPLICATE_TOKEN";
}
