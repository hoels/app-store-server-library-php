<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A message identifier and status information for a message.
 *
 * https://developer.apple.com/documentation/retentionmessaging/getmessagelistresponseitem
 */
class GetMessageListResponseItem
{
    public function __construct(
        private readonly ?string $messageIdentifier,
        private readonly ?MessageState $messageState,
    ) {
    }

    /**
     * The identifier of the message.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageidentifier
     */
    public function getMessageIdentifier(): ?string
    {
        return $this->messageIdentifier;
    }

    /**
     * The current state of the message.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageState
     */
    public function getMessageState(): ?MessageState
    {
        return $this->messageState;
    }

    public static function fromObject(stdClass $obj): GetMessageListResponseItem
    {
        return new GetMessageListResponseItem(
            messageIdentifier: property_exists($obj, "messageIdentifier") && is_string($obj->messageIdentifier)
                ? $obj->messageIdentifier : null,
            messageState: property_exists($obj, "messageState") && is_string($obj->messageState)
                ? MessageState::tryFrom($obj->messageState) : null,
        );
    }
}
