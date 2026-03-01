<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The definition of an image with its alternative text.
 *
 * https://developer.apple.com/documentation/retentionmessaging/uploadmessageimage
 */
class UploadMessageImage implements JsonSerializable
{
    public function __construct(
        private readonly string $imageIdentifier,
        private readonly string $altText,
    ) {
    }

    /**
     * The unique identifier of an image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imageidentifier
     */
    public function getImageIdentifier(): string
    {
        return $this->imageIdentifier;
    }

    /**
     * The alternative text you provide for the corresponding image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/alttext
     */
    public function getAltText(): string
    {
        return $this->altText;
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
