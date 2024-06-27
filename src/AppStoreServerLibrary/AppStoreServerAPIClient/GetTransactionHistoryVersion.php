<?php

namespace AppStoreServerLibrary\AppStoreServerAPIClient;

enum GetTransactionHistoryVersion: string
{
    /** @deprecated 1.3.0 */
    case V1 = "v1";
    case V2 = "v2";
}
