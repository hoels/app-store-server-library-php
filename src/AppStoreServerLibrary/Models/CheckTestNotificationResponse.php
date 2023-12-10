<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains the contents of the test notification sent by the App Store server and the result from your
 * server.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/checktestnotificationresponse
 */
class CheckTestNotificationResponse
{
    /**
     * @param SendAttemptItem[]|null $sendAttempts
     */
    public function __construct(
        private readonly ?string $signedPayload,
        private readonly ?array $sendAttempts,
    ) {
    }

    /**
     * A cryptographically signed payload, in JSON Web Signature (JWS) format, containing the response body for a
     * version 2 notification.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/signedpayload
     */
    public function getSignedPayload(): ?string
    {
        return $this->signedPayload;
    }

    /**
     * An array of information the App Store server records for its attempts to send the TEST notification to your
     * server. The array may contain a maximum of six sendAttemptItem objects.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
     *
     * @return SendAttemptItem[]|null
     */
    public function getSendAttempts(): ?array
    {
        return $this->sendAttempts;
    }

    public static function fromObject(stdClass $obj): CheckTestNotificationResponse
    {
        return new CheckTestNotificationResponse(
            signedPayload: property_exists($obj, "signedPayload") && is_string($obj->signedPayload)
                ? $obj->signedPayload : null,
            sendAttempts: property_exists($obj, "sendAttempts") && is_array($obj->sendAttempts)
                ? array_map(
                    fn ($sendAttemptItem) => SendAttemptItem::fromObject((object)$sendAttemptItem),
                    array_filter($obj->sendAttempts, fn($sendAttemptItem)
                        => $sendAttemptItem instanceof stdClass || is_array($sendAttemptItem))
                ) : null
        );
    }
}
