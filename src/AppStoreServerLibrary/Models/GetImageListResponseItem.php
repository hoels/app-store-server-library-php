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

    public static function fromObject(stdClass $obj): GetImageListResponseItem
    {
        return new GetImageListResponseItem(
            imageIdentifier: property_exists($obj, "imageIdentifier") && is_string($obj->imageIdentifier)
                ? $obj->imageIdentifier : null,
            imageState: property_exists($obj, "imageState") && is_string($obj->imageState)
                ? ImageState::tryFrom($obj->imageState) : null,
        );
    }
}
