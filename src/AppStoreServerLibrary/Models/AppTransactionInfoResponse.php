<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains signed app transaction information for a customer.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/apptransactioninforesponse
 */
class AppTransactionInfoResponse
{
    public function __construct(
        private readonly ?string $signedAppTransactionInfo,
    ) {
    }

    /**
     * App transaction information signed by the App Store, in JSON Web Signature (JWS) Compact Serialization format.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/jwsapptransaction
     */
    public function getSignedAppTransactionInfo(): ?string
    {
        return $this->signedAppTransactionInfo;
    }

    public static function fromObject(stdClass $obj): AppTransactionInfoResponse
    {
        return new AppTransactionInfoResponse(
            signedAppTransactionInfo: property_exists($obj, "signedAppTransactionInfo")
                && is_string($obj->signedAppTransactionInfo)
                ? $obj->signedAppTransactionInfo : null
        );
    }
}
