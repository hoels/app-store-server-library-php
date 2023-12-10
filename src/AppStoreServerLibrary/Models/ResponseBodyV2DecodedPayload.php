<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A decoded payload containing the version 2 notification data.
 *
 * https://developer.apple.com/documentation/appstoreservernotifications/responsebodyv2decodedpayload
 */
class ResponseBodyV2DecodedPayload
{
    public function __construct(
        private readonly ?NotificationTypeV2 $notificationType,
        private readonly ?Subtype $subtype,
        private readonly ?Data $data,
        private readonly ?Summary $summary,
        private readonly ?string $version,
        private readonly ?int $signedDate,
        private readonly ?string $notificationUUID,
    ) {
    }

    /**
     * The in-app purchase event for which the App Store sends this version 2 notification.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/notificationtype
     */
    public function getNotificationType(): ?NotificationTypeV2
    {
        return $this->notificationType;
    }

    /**
     * Additional information that identifies the notification event. The subtype field is present only for specific
     * version 2 notifications.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/subtype
     */
    public function getSubtype(): ?Subtype
    {
        return $this->subtype;
    }

    /**
     * The object that contains the app metadata and signed renewal and transaction information.
     * The data and summary fields are mutually exclusive. The payload contains one of the fields, but not both.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/data
     */
    public function getData(): ?Data
    {
        return $this->data;
    }

    /**
     * The summary data that appears when the App Store server completes your request to extend a subscription renewal
     * date for eligible subscribers.
     * The data and summary fields are mutually exclusive. The payload contains one of the fields, but not both.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/summary
     */
    public function getSummary(): ?Summary
    {
        return $this->summary;
    }

    /**
     * A string that indicates the notification's App Store Server Notifications version number.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/version
     */
    public function getVersion(): ?string
    {
        return $this->version;
    }

    /**
     * The UNIX time, in milliseconds, that the App Store signed the JSON Web Signature data.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/signeddate
     */
    public function getSignedDate(): ?int
    {
        return $this->signedDate;
    }

    /**
     * A unique identifier for the notification.
     *
     * https://developer.apple.com/documentation/appstoreservernotifications/notificationuuid
     */
    public function getNotificationUUID(): ?string
    {
        return $this->notificationUUID;
    }

    public static function fromObject(stdClass $obj): ResponseBodyV2DecodedPayload
    {
        return new ResponseBodyV2DecodedPayload(
            notificationType:property_exists($obj, "notificationType") && is_string($obj->notificationType)
                ? NotificationTypeV2::tryFrom($obj->notificationType) : null,
            subtype: property_exists($obj, "subtype") && is_string($obj->subtype)
                ? Subtype::tryFrom($obj->subtype) : null,
            data: property_exists($obj, "data") && ($obj->data instanceof stdClass || is_array($obj->data))
                ? Data::fromObject((object)$obj->data) : null,
            summary: property_exists($obj, "summary") && ($obj->summary instanceof stdClass || is_array($obj->summary))
                ? Summary::fromObject((object)$obj->summary) : null,
            version: property_exists($obj, "version") && is_string($obj->version)
                ? $obj->version : null,
            signedDate: property_exists($obj, "signedDate")
                && (is_int($obj->signedDate) || is_float($obj->signedDate))
                ? intval($obj->signedDate) : null,
            notificationUUID: property_exists($obj, "notificationUUID") && is_string($obj->notificationUUID)
                ? $obj->notificationUUID : null
        );
    }
}
