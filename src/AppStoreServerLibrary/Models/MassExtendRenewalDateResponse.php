<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that indicates the server successfully received the subscription-renewal-date extension request.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/massextendrenewaldateresponse
 */
class MassExtendRenewalDateResponse
{
    public function __construct(
        private readonly ?string $requestIdentifier,
    ) {
    }

    /**
     * A string that contains a unique identifier you provide to track each subscription-renewal-date extension request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/requestidentifier
     */
    public function getRequestIdentifier(): ?string
    {
        return $this->requestIdentifier;
    }

    public static function fromObject(stdClass $obj): MassExtendRenewalDateResponse
    {
        return new MassExtendRenewalDateResponse(
            requestIdentifier: property_exists($obj, "requestIdentifier") && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null
        );
    }
}
