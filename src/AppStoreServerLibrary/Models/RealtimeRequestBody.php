<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The request body the App Store server sends to your Get Retention Message endpoint.
 *
 * https://developer.apple.com/documentation/retentionmessaging/realtimerequestbody
 */
class RealtimeRequestBody
{
    public function __construct(
        private readonly ?string $signedPayload,
    ) {
    }

    /**
     * The payload in JSON Web Signature (JWS) format, signed by the App Store.
     *
     * https://developer.apple.com/documentation/retentionmessaging/signedpayload
     */
    public function getSignedPayload(): ?string
    {
        return $this->signedPayload;
    }

    public static function fromObject(stdClass $obj): RealtimeRequestBody
    {
        return new RealtimeRequestBody(
            signedPayload: property_exists($obj, "signedPayload") && is_string($obj->signedPayload)
                ? $obj->signedPayload : null,
        );
    }

    /**
     * @param array<string, mixed> $array
     */
    public static function fromArray(array $array): RealtimeRequestBody
    {
        return RealtimeRequestBody::fromObject((object)$array);
    }
}
