<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body for notification history.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryrequest
 */
class NotificationHistoryRequest implements JsonSerializable
{
    public function __construct(
        private readonly int $startDate,
        private readonly int $endDate,
        private readonly ?NotificationTypeV2 $notificationType = null,
        private readonly ?Subtype $notificationSubtype = null,
        private readonly ?string $transactionId = null,
        private readonly ?bool $onlyFailures = null,
    ) {
    }

    /**
     * The start date of the timespan for the requested App Store Server Notification history records. The startDate
     * needs to precede the endDate. Choose a startDate that's within the past 180 days from the current date.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/startdate
     */
    public function getStartDate(): int
    {
        return $this->startDate;
    }

    /**
     * The end date of the timespan for the requested App Store Server Notification history records. Choose an endDate
     * that's later than the startDate. If you choose an endDate in the future, the endpoint automatically uses the
     * current date as the endDate.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/enddate
     */
    public function getEndDate(): int
    {
        return $this->endDate;
    }

    /**
     * A notification type. Provide this field to limit the notification history records to those with this one
     * notification type. For a list of notifications types, see notificationType.
     * Include either the transactionId or the notificationType in your query, but not both.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/notificationtype
     */
    public function getNotificationType(): ?NotificationTypeV2
    {
        return $this->notificationType;
    }

    /**
     * A notification subtype. Provide this field to limit the notification history records to those with this one
     * notification subtype. For a list of subtypes, see subtype. If you specify a notificationSubtype, you need to also
     * specify its related notificationType.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/notificationsubtype
     */
    public function getNotificationSubtype(): ?Subtype
    {
        return $this->notificationSubtype;
    }

    /**
     * The transaction identifier, which may be an original transaction identifier, of any transaction belonging to the
     * customer. Provide this field to limit the notification history request to this one customer.
     * Include either the transactionId or the notificationType in your query, but not both.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/transactionid
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * A Boolean value you set to true to request only the notifications that haven’t reached your server successfully.
     * The response also includes notifications that the App Store server is currently retrying to send to your server.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/onlyfailures
     */
    public function getOnlyFailures(): ?bool
    {
        return $this->onlyFailures;
    }

    /**
     * @return array<string, int|int[]|string|string[]|boolean|boolean[]|null>
     */
    public function jsonSerialize(): array
    {
        $array = [];
        /**
         * @var string $key
         * @var int|int[]|string|string[]|boolean|boolean[]|null $value
         * @phpstan-ignore foreach.nonIterable
         */
        foreach ($this as $key => $value) {
            if ($value !== null) {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
