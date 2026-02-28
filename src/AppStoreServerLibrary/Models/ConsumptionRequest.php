<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body containing consumption information.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/consumptionrequest
 */
class ConsumptionRequest implements JsonSerializable
{
    public function __construct(
        private readonly bool $customerConsented,
        private readonly bool $sampleContentProvided,
        private readonly DeliveryStatus $deliveryStatus,
        private readonly ?int $consumptionPercentage,
        private readonly ?RefundPreference $refundPreference,
    ) {
    }

    /**
     * A Boolean value that indicates whether the customer consented to provide consumption data to the App Store.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/customerconsented
     */
    public function getCustomerConsented(): bool
    {
        return $this->customerConsented;
    }

    /**
     * A Boolean value that indicates whether you provided, prior to its purchase, a free sample or trial of the
     * content, or information about its functionality.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/samplecontentprovided
     */
    public function getSampleContentProvided(): bool
    {
        return $this->sampleContentProvided;
    }

    /**
     * A value that indicates whether the app successfully delivered an in-app purchase that works properly.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/deliverystatus
     */
    public function getDeliveryStatus(): DeliveryStatus
    {
        return $this->deliveryStatus;
    }

    /**
     * An integer that indicates the percentage, in milliunits, of the In-App Purchase the customer consumed.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/consumptionpercentage
     */
    public function getConsumptionPercentage(): ?int
    {
        return $this->consumptionPercentage;
    }

    /**
     * A value that indicates your preferred outcome for the refund request.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/refundpreference
     */
    public function getRefundPreference(): ?RefundPreference
    {
        return $this->refundPreference;
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
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
