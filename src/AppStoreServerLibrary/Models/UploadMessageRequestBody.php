<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body for uploading a message, which includes the message text and an optional image reference.
 *
 * https://developer.apple.com/documentation/retentionmessaging/uploadmessagerequestbody
 */
class UploadMessageRequestBody implements JsonSerializable
{
    /**
     * @param BulletPoint[]|null $bulletPoints
     */
    public function __construct(
        private readonly string $header,
        private readonly string $body,
        private readonly ?UploadMessageImage $image = null,
        private readonly ?HeaderPosition $headerPosition = null,
        private readonly ?array $bulletPoints = null,
    ) {
    }

    /**
     * The header text of the retention message that the system displays to customers.
     *
     * https://developer.apple.com/documentation/retentionmessaging/header
     */
    public function getHeader(): string
    {
        return $this->header;
    }

    /**
     * The body text of the retention message that the system displays to customers.
     *
     * https://developer.apple.com/documentation/retentionmessaging/body
     */
    public function getBody(): string
    {
        return $this->body;
    }

    /**
     * The optional image identifier and its alternative text to appear as part of a text-based message with an image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/uploadmessageimage
     */
    public function getImage(): ?UploadMessageImage
    {
        return $this->image;
    }

    /**
     * The position of header text, which defaults to placing header text above the body.
     *
     * https://developer.apple.com/documentation/retentionmessaging/headerposition
     */
    public function getHeaderPosition(): ?HeaderPosition
    {
        return $this->headerPosition;
    }

    /**
     * An optional array of bullet points.
     *
     * https://developer.apple.com/documentation/retentionmessaging/bulletpoint
     *
     * @return BulletPoint[]|null
     */
    public function getBulletPoints(): ?array
    {
        return $this->bulletPoints;
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
                $array[$key] = $value instanceof JsonSerializable ? $value->jsonSerialize() : $value;
            }
        }

        return $array;
    }
}
