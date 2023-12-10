<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains the test notification token.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/sendtestnotificationresponse
 */
class SendTestNotificationResponse
{
    public function __construct(
        private readonly ?string $testNotificationToken,
    ) {
    }

    /**
     * A unique identifier for a notification test that the App Store server sends to your server.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/testnotificationtoken
     */
    public function getTestNotificationToken(): ?string
    {
        return $this->testNotificationToken;
    }

    public static function fromObject(stdClass $obj): SendTestNotificationResponse
    {
        return new SendTestNotificationResponse(
            testNotificationToken: property_exists($obj, "testNotificationToken")
                && is_string($obj->testNotificationToken)
                ? $obj->testNotificationToken : null
        );
    }
}
