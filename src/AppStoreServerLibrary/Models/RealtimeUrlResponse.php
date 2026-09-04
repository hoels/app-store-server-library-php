<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The response body that contains the URL for your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/realtimeurlresponse
 */
class RealtimeUrlResponse
{
    public function __construct(
        private readonly ?string $realtimeURL,
    ) {
    }

    /**
     * A string that contains the URL you provided for your Get Retention Message endpoint.
     *
     * https://developer.apple.com/documentation/retentionmessaging/realtimeurl
     */
    public function getRealtimeURL(): ?string
    {
        return $this->realtimeURL;
    }

    public static function fromObject(stdClass $obj): RealtimeUrlResponse
    {
        return new RealtimeUrlResponse(
            realtimeURL: property_exists($obj, "realtimeURL") && is_string($obj->realtimeURL)
                ? $obj->realtimeURL : null,
        );
    }
}
