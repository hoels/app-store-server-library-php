<?php

namespace AppStoreServerLibrary\Models\TransactionHistoryRequest;

enum ProductType: string
{
    case AUTO_RENEWABLE = "AUTO_RENEWABLE";
    case NON_RENEWABLE = "NON_RENEWABLE";
    case CONSUMABLE = "CONSUMABLE";
    case NON_CONSUMABLE = "NON_CONSUMABLE";
}
