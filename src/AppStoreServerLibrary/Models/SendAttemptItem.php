<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The success or error information and the date the App Store server records when it attempts to send a server
 * notification to your server.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/sendattemptitem
 */
class SendAttemptItem
{
    public function __construct(
        private readonly ?int $attemptDate,
        private readonly ?SendAttemptResult $sendAttemptResult,
    ) {
    }

    /**
     * The date the App Store server attempts to send a notification.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/attemptdate
     */
    public function getAttemptDate(): ?int
    {
        return $this->attemptDate;
    }

    /**
     * The success or error information the App Store server records when it attempts to send an App Store server
     * notification to your server.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/sendattemptresult
     */
    public function getSendAttemptResult(): ?SendAttemptResult
    {
        return $this->sendAttemptResult;
    }

    public static function fromObject(stdClass $obj): SendAttemptItem
    {
        return new SendAttemptItem(
            attemptDate: property_exists($obj, "attemptDate")
                && (is_int($obj->attemptDate) || is_float($obj->attemptDate))
                ? intval($obj->attemptDate) : null,
            sendAttemptResult: property_exists($obj, "sendAttemptResult") && is_string($obj->sendAttemptResult)
                ? SendAttemptResult::tryFrom($obj->sendAttemptResult) : null
        );
    }
}
