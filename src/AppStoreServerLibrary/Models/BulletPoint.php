<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The text and its bullet-point image to include in a retention message’s bulleted list.
 *
 * https://developer.apple.com/documentation/retentionmessaging/bulletpoint
 */
class BulletPoint implements JsonSerializable
{
    public function __construct(
        private readonly string $text,
        private readonly string $imageIdentifier,
        private readonly string $altText,
    ) {
    }

    /**
     * The text of the individual bullet point.
     *
     * https://developer.apple.com/documentation/retentionmessaging/bulletpointtext
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * The identifier of the image to use as the bullet point.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imageidentifier
     */
    public function getImageIdentifier(): string
    {
        return $this->imageIdentifier;
    }

    /**
     * The alternative text you provide for the corresponding image of the bullet point.
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
