<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * https://developer.apple.com/documentation/appstoreserverapi/renewalcommitmentinfo
 */
class RenewalCommitmentInfo
{
    public function __construct(
        private readonly ?string $commitmentAutoRenewProductId,
        private readonly ?AutoRenewStatus $commitmentAutoRenewStatus,
        private readonly ?RenewalBillingPlanType $commitmentRenewalBillingPlanType,
        private readonly ?int $commitmentRenewalDate,
        private readonly ?int $commitmentRenewalPrice,
    ) {
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentautorenewproductid
     */
    public function getCommitmentAutoRenewProductId(): ?string
    {
        return $this->commitmentAutoRenewProductId;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentautorenewstatus
     */
    public function getCommitmentAutoRenewStatus(): ?AutoRenewStatus
    {
        return $this->commitmentAutoRenewStatus;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentrenewalbillingplantype
     */
    public function getCommitmentRenewalBillingPlanType(): ?RenewalBillingPlanType
    {
        return $this->commitmentRenewalBillingPlanType;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentrenewaldate
     */
    public function getCommitmentRenewalDate(): ?int
    {
        return $this->commitmentRenewalDate;
    }

    /**
     * https://developer.apple.com/documentation/appstoreserverapi/commitmentrenewalprice
     */
    public function getCommitmentRenewalPrice(): ?int
    {
        return $this->commitmentRenewalPrice;
    }

    public static function fromObject(stdClass $obj): RenewalCommitmentInfo
    {
        return new RenewalCommitmentInfo(
            commitmentAutoRenewProductId: property_exists($obj, "commitmentAutoRenewProductId")
                && is_string($obj->commitmentAutoRenewProductId)
                ? $obj->commitmentAutoRenewProductId : null,
            commitmentAutoRenewStatus: property_exists($obj, "commitmentAutoRenewStatus")
                && is_int($obj->commitmentAutoRenewStatus)
                ? AutoRenewStatus::tryFrom($obj->commitmentAutoRenewStatus) : null,
            commitmentRenewalBillingPlanType: property_exists($obj, "commitmentRenewalBillingPlanType")
                && is_string($obj->commitmentRenewalBillingPlanType)
                ? RenewalBillingPlanType::tryFrom($obj->commitmentRenewalBillingPlanType) : null,
            commitmentRenewalDate: property_exists($obj, "commitmentRenewalDate")
                && is_int($obj->commitmentRenewalDate)
                ? $obj->commitmentRenewalDate : null,
            commitmentRenewalPrice: property_exists($obj, "commitmentRenewalPrice")
                && is_int($obj->commitmentRenewalPrice)
                ? $obj->commitmentRenewalPrice : null,
        );
    }
}
