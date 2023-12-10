<?php

namespace AppStoreServerLibrary\Models;

/**
 * The relationship of the user with the family-shared purchase to which they have access.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/inappownershiptype
 */
enum InAppOwnershipType: string
{
    case FAMILY_SHARED = "FAMILY_SHARED";
    case PURCHASED = "PURCHASED";
}
