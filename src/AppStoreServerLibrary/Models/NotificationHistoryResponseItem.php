<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The App Store server notification history record, including the signed notification payload and the result of the
 * server's first send attempt.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponseitem
 */
class NotificationHistoryResponseItem
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
     * An array of information the App Store server records for its attempts to send a notification to your server. The
     * maximum number of entries in the array is six.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
     *
     * @return SendAttemptItem[]|null
     */
    public function getSendAttempts(): ?array
    {
        return $this->sendAttempts;
    }

    public static function fromObject(stdClass $obj): NotificationHistoryResponseItem
    {
        return new NotificationHistoryResponseItem(
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
