<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains the App Store Server Notifications history for your app.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/notificationhistoryresponse
 */
class NotificationHistoryResponse
{
    /**
     * @param NotificationHistoryResponseItem[]|null $notificationHistory
     */
    public function __construct(
        private readonly ?string $paginationToken,
        private readonly ?bool $hasMore,
        private readonly ?array $notificationHistory,
    ) {
    }

    /**
     * A pagination token that you return to the endpoint on a subsequent call to receive the next set of results.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/paginationtoken
     */
    public function getPaginationToken(): ?string
    {
        return $this->paginationToken;
    }

    /**
     * A Boolean value indicating whether the App Store has more transaction data.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/hasmore
     */
    public function getHasMore(): ?bool
    {
        return $this->hasMore;
    }

    /**
     * An array of App Store server notification history records.
     *
     * @return NotificationHistoryResponseItem[]|null
     */
    public function getNotificationHistory(): ?array
    {
        return $this->notificationHistory;
    }

    public static function fromObject(stdClass $obj): NotificationHistoryResponse
    {
        return new NotificationHistoryResponse(
            paginationToken: property_exists($obj, "paginationToken") && is_string($obj->paginationToken)
                ? $obj->paginationToken : null,
            hasMore: property_exists($obj, "hasMore") && is_bool($obj->hasMore)
                ? $obj->hasMore : null,
            notificationHistory: property_exists($obj, "notificationHistory") && is_array($obj->notificationHistory)
                ? array_map(
                    fn ($notificationHistoryResponseItem)
                        => NotificationHistoryResponseItem::fromObject((object)$notificationHistoryResponseItem),
                    array_filter($obj->notificationHistory, fn($notificationHistoryResponseItem)
                        => $notificationHistoryResponseItem instanceof stdClass
                            || is_array($notificationHistoryResponseItem))
                ) : null
        );
    }
}
