<?php

namespace AppStoreServerLibrary\Models\TransactionHistoryRequest;

enum Order: string
{
    case ASCENDING = "ASCENDING";
    case DESCENDING = "DESCENDING";
}
