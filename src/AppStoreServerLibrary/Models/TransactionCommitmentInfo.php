<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * https://developer.apple.com/documentation/appstoreserverapi/renewalcommitmentinfo
 */
class TransactionCommitmentInfo
{
    public function __construct(
        private readonly ?int $billingPeriodNumber,
        private readonly ?int $commitmentExpiresDate,
        private readonly ?int $commitmentPrice,
        private readonly ?int $totalBillingPeriods,
    ) {
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/billingperiodnumber
     */
    public function getBillingPeriodNumber(): ?int
    {
        return $this->billingPeriodNumber;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentexpiresdate
     */
    public function getCommitmentExpiresDate(): ?int
    {
        return $this->commitmentExpiresDate;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentprice
     */
    public function getCommitmentPrice(): ?int
    {
        return $this->commitmentPrice;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/totalbillingperiods
     */
    public function getTotalBillingPeriods(): ?int
    {
        return $this->totalBillingPeriods;
    }

    public static function fromObject(stdClass $obj): TransactionCommitmentInfo
    {
        return new TransactionCommitmentInfo(
            billingPeriodNumber: property_exists($obj, "billingPeriodNumber")
                && is_int($obj->billingPeriodNumber)
                ? $obj->billingPeriodNumber : null,
            commitmentExpiresDate: property_exists($obj, "commitmentExpiresDate")
                && is_int($obj->commitmentExpiresDate)
                ? $obj->commitmentExpiresDate : null,
            commitmentPrice: property_exists($obj, "commitmentPrice")
                && is_int($obj->commitmentPrice)
                ? $obj->commitmentPrice : null,
            totalBillingPeriods: property_exists($obj, "totalBillingPeriods")
                && is_int($obj->totalBillingPeriods)
                ? $obj->totalBillingPeriods : null,
        );
    }
}
