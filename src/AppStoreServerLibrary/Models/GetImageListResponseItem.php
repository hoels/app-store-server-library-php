<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * An image identifier and state information for an image.
 *
 * https://developer.apple.com/documentation/retentionmessaging/getimagelistresponseitem
 */
class GetImageListResponseItem
{
    public function __construct(
        private readonly ?string $imageIdentifier,
        private readonly ?ImageState $imageState,
        private readonly ?ImageSize $imageSize,
    ) {
    }

    /**
     * The identifier of the image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imageidentifier
     */
    public function getImageIdentifier(): ?string
    {
        return $this->imageIdentifier;
    }

    /**
     * The current state of the image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imagestate
     */
    public function getImageState(): ?ImageState
    {
        return $this->imageState;
    }

    /**
     * The size of the image.
     *
     * https://developer.apple.com/documentation/retentionmessaging/imagesize
     */
    public function getImageSize(): ?ImageSize
    {
        return $this->imageSize;
    }

    public static function fromObject(stdClass $obj): GetImageListResponseItem
    {
        return new GetImageListResponseItem(
            imageIdentifier: property_exists($obj, "imageIdentifier") && is_string($obj->imageIdentifier)
                ? $obj->imageIdentifier : null,
            imageState: property_exists($obj, "imageState") && is_string($obj->imageState)
                ? ImageState::tryFrom($obj->imageState) : null,
            imageSize: property_exists($obj, "imageSize") && is_string($obj->imageSize)
                ? ImageSize::tryFrom($obj->imageSize) : null,
        );
    }
}
