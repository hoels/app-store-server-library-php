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
        private readonly ConsumptionStatus $consumptionStatus,
        private readonly Platform $platform,
        private readonly bool $sampleContentProvided,
        private readonly DeliveryStatus $deliveryStatus,
        private readonly string $appAccountToken,
        private readonly AccountTenure $accountTenure,
        private readonly PlayTime $playTime,
        private readonly LifetimeDollarsRefunded $lifetimeDollarsRefunded,
        private readonly LifetimeDollarsPurchased $lifetimeDollarsPurchased,
        private readonly UserStatus $userStatus,
        private readonly RefundPreference $refundPreference,
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
     * A value that indicates the extent to which the customer consumed the in-app purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/consumptionstatus
     */
    public function getConsumptionStatus(): ConsumptionStatus
    {
        return $this->consumptionStatus;
    }

    /**
     * A value that indicates the platform on which the customer consumed the in-app purchase.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/platform
     */
    public function getPlatform(): Platform
    {
        return $this->platform;
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
     * The UUID that an app optionally generates to map a customer's in-app purchase with its resulting App Store
     * transaction.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/appaccounttoken
     */
    public function getAppAccountToken(): string
    {
        return $this->appAccountToken;
    }

    /**
     * The age of the customer's account.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/accounttenure
     */
    public function getAccountTenure(): AccountTenure
    {
        return $this->accountTenure;
    }

    /**
     * A value that indicates the amount of time that the customer used the app.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/consumptionrequest
     */
    public function getPlayTime(): PlayTime
    {
        return $this->playTime;
    }

    /**
     * A value that indicates the total amount, in USD, of refunds the customer has received, in your app, across all
     * platforms.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarsrefunded
     */
    public function getLifetimeDollarsRefunded(): LifetimeDollarsRefunded
    {
        return $this->lifetimeDollarsRefunded;
    }

    /**
     * A value that indicates the total amount, in USD, of in-app purchases the customer has made in your app, across
     * all platforms.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/lifetimedollarspurchased
     */
    public function getLifetimeDollarsPurchased(): LifetimeDollarsPurchased
    {
        return $this->lifetimeDollarsPurchased;
    }

    /**
     * The status of the customer's account.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/userstatus
     */
    public function getUserStatus(): UserStatus
    {
        return $this->userStatus;
    }

    /**
     * A value that indicates your preference, based on your operational logic, as to whether Apple should grant the
     * refund.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/refundpreference
     */
    public function getRefundPreference(): RefundPreference
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
         */
        foreach ($this as $key => $value) {
            if ($value !== null) {
                $array[$key] = $value;
            }
        }

        return $array;
    }
}
