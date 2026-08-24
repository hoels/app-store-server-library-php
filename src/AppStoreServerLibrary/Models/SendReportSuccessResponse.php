<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains the request identifier and indicates the server successfully received your external
 * purchase report.
 *
 * https://developer.apple.com/documentation/externalpurchaseserverapi/sendreportsuccessresponse
 */
class SendReportSuccessResponse
{
    public function __construct(
        private readonly ?string $requestIdentifier,
    ) {
    }

    /**
     * A UUID that uniquely identifies an external purchase report.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/testnotificationtoken
     */
    public function getRequestIdentifier(): ?string
    {
        return $this->requestIdentifier;
    }

    public static function fromObject(stdClass $obj): SendReportSuccessResponse
    {
        return new SendReportSuccessResponse(
            requestIdentifier: property_exists($obj, "requestIdentifier")
                && is_string($obj->requestIdentifier)
                ? $obj->requestIdentifier : null
        );
    }
}
