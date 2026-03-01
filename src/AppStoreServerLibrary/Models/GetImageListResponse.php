<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * A response that contains status information for all images.
 *
 * https://developer.apple.com/documentation/retentionmessaging/getimagelistresponse
 */
class GetImageListResponse
{
    /**
     * @param GetImageListResponseItem[] $imageIdentifiers
     */
    public function __construct(
        private readonly array $imageIdentifiers,
    ) {
    }

    /**
     * An array of all image identifiers and their image state.
     *
     * https://developer.apple.com/documentation/retentionmessaging/getimagelistresponseitem
     *
     * @return GetImageListResponseItem[]
     */
    public function getImageIdentifiers(): array
    {
        return $this->imageIdentifiers;
    }

    public static function fromObject(stdClass $obj): GetImageListResponse
    {
        return new GetImageListResponse(
            imageIdentifiers: property_exists($obj, "imageIdentifiers") && is_array($obj->imageIdentifiers)
                ? array_map(
                    fn ($imageIdentifierItem) => GetImageListResponseItem::fromObject((object)$imageIdentifierItem),
                    array_filter($obj->imageIdentifiers, fn($imageIdentifierItem)
                    => $imageIdentifierItem instanceof stdClass || is_array($imageIdentifierItem))
                ) : [],
        );
    }
}
