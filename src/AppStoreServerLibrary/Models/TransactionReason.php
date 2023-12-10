<?php

namespace AppStoreServerLibrary\Models;

/**
 * The cause of a purchase transaction, which indicates whether it’s a customer’s purchase or a renewal for an
 * auto-renewable subscription that the system initiates.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/transactionreason
 */
enum TransactionReason: string
{
    case PURCHASE = "PURCHASE";
    case RENEWAL = "RENEWAL";
}
