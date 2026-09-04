<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The response body that contains the default configuration information.
 *
 * https://developer.apple.com/documentation/retentionmessaging/defaultconfigurationresponse
 */
class DefaultConfigurationResponse
{
    public function __construct(
        private readonly ?string $messageIdentifier,
    ) {
    }

    /**
     * The message identifier of the retention message you configured as a default.
     *
     * https://developer.apple.com/documentation/retentionmessaging/messageidentifier
     */
    public function getMessageIdentifier(): ?string
    {
        return $this->messageIdentifier;
    }

    public static function fromObject(stdClass $obj): DefaultConfigurationResponse
    {
        return new DefaultConfigurationResponse(
            messageIdentifier: property_exists($obj, "messageIdentifier") && is_string($obj->messageIdentifier)
                ? $obj->messageIdentifier : null,
        );
    }
}
