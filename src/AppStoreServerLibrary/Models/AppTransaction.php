<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

class AppTransaction
{
    public function __construct(
        private readonly ?Environment $receiptType,
        private readonly ?int $appAppleId,
        private readonly ?string $bundleId,
        private readonly ?string $applicationVersion,
        private readonly ?int $versionExternalIdentifier,
        private readonly ?int $receiptCreationDate,
        private readonly ?int $originalPurchaseDate,
        private readonly ?string $originalApplicationVersion,
        private readonly ?string $deviceVerification,
        private readonly ?string $deviceVerificationNonce,
        private readonly ?int $preorderDate,
    ) {
    }

    /**
     * The server environment that signs the app transaction.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3963901-environment
     */
    public function getReceiptType(): ?Environment
    {
        return $this->receiptType;
    }

    /**
     * The unique identifier the App Store uses to identify the app.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954436-appid
     */
    public function getAppAppleId(): ?int
    {
        return $this->appAppleId;
    }

    /**
     * The bundle identifier that the app transaction applies to.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954439-bundleid
     */
    public function getBundleId(): ?string
    {
        return $this->bundleId;
    }

    /**
     * The app version that the app transaction applies to.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954437-appversion
     */
    public function getApplicationVersion(): ?string
    {
        return $this->applicationVersion;
    }

    /**
     * The version external identifier of the app
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954438-appversionid
     */
    public function getVersionExternalIdentifier(): ?int
    {
        return $this->versionExternalIdentifier;
    }

    /**
     * The date that the App Store signed the JWS app transaction.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954449-signeddate
     */
    public function getReceiptCreationDate(): ?int
    {
        return $this->receiptCreationDate;
    }

    /**
     * The date the user originally purchased the app from the App Store.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954448-originalpurchasedate
     */
    public function getOriginalPurchaseDate(): ?int
    {
        return $this->originalPurchaseDate;
    }

    /**
     * The app version that the user originally purchased from the App Store.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954447-originalappversion
     */
    public function getOriginalApplicationVersion(): ?string
    {
        return $this->originalApplicationVersion;
    }

    /**
     * The Base64 device verification value to use to verify whether the app transaction belongs to the device.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954441-deviceverification
     */
    public function getDeviceVerification(): ?string
    {
        return $this->deviceVerification;
    }

    /**
     * The UUID used to compute the device verification value.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/3954442-deviceverificationnonce
     */
    public function getDeviceVerificationNonce(): ?string
    {
        return $this->deviceVerificationNonce;
    }

    /**
     * The date the customer placed an order for the app before it's available in the App Store.
     *
     * https://developer.apple.com/documentation/storekit/apptransaction/4013175-preorderdate
     */
    public function getPreorderDate(): ?int
    {
        return $this->preorderDate;
    }

    public static function fromObject(stdClass $obj): AppTransaction
    {
        return new AppTransaction(
            receiptType: property_exists($obj, "receiptType") && is_string($obj->receiptType)
                ? Environment::tryFrom($obj->receiptType) : null,
            appAppleId: property_exists($obj, "appAppleId") && is_int($obj->appAppleId)
                ? $obj->appAppleId : null,
            bundleId: property_exists($obj, "bundleId") && is_string($obj->bundleId)
                ? $obj->bundleId : null,
            applicationVersion: property_exists($obj, "applicationVersion") && is_string($obj->applicationVersion)
                ? $obj->applicationVersion : null,
            versionExternalIdentifier: property_exists($obj, "versionExternalIdentifier")
                && is_int($obj->versionExternalIdentifier)
                ? $obj->versionExternalIdentifier : null,
            receiptCreationDate: property_exists($obj, "receiptCreationDate")
                && (is_int($obj->receiptCreationDate) || is_float($obj->receiptCreationDate))
                ? intval($obj->receiptCreationDate) : null,
            originalPurchaseDate: property_exists($obj, "originalPurchaseDate")
                && (is_int($obj->originalPurchaseDate) || is_float($obj->originalPurchaseDate))
                ? intval($obj->originalPurchaseDate) : null,
            originalApplicationVersion: property_exists($obj, "originalApplicationVersion")
                && is_string($obj->originalApplicationVersion)
                ? $obj->originalApplicationVersion : null,
            deviceVerification: property_exists($obj, "deviceVerification") && is_string($obj->deviceVerification)
                ? $obj->deviceVerification : null,
            deviceVerificationNonce: property_exists($obj, "deviceVerificationNonce")
                && is_string($obj->deviceVerificationNonce)
                ? $obj->deviceVerificationNonce : null,
            preorderDate: property_exists($obj, "preorderDate")
                && (is_int($obj->preorderDate) || is_float($obj->preorderDate))
                ? intval($obj->preorderDate) : null,
        );
    }
}
