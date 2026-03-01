<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains status information for all messages.
 *
 * https://developer.apple.com/documentation/retentionmessaging/getmessagelistresponse
 */
class GetMessageListResponse
{
    /**
     * @param GetMessageListResponseItem[] $messageIdentifiers
     */
    public function __construct(
        private readonly array $messageIdentifiers,
    ) {
    }

    /**
     * An array of all message identifiers and their message state.
     *
     * https://developer.apple.com/documentation/retentionmessaging/getmessagelistresponseitem
     *
     * @return GetMessageListResponseItem[]
     */
    public function getMessageIdentifiers(): array
    {
        return $this->messageIdentifiers;
    }

    public static function fromObject(stdClass $obj): GetMessageListResponse
    {
        return new GetMessageListResponse(
            messageIdentifiers: property_exists($obj, "messageIdentifiers") && is_array($obj->messageIdentifiers)
                ? array_map(
                    fn ($messageIdentifierItem) => GetMessageListResponseItem::fromObject(
                        (object)$messageIdentifierItem
                    ),
                    array_filter($obj->messageIdentifiers, fn($messageIdentifierItem)
                    => $messageIdentifierItem instanceof stdClass || is_array($messageIdentifierItem))
                ) : [],
        );
    }
}
