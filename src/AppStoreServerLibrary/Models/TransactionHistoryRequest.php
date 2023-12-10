<?php

namespace AppStoreServerLibrary\Models;

use AppStoreServerLibrary\Models\TransactionHistoryRequest\Order;
use AppStoreServerLibrary\Models\TransactionHistoryRequest\ProductType;
use JsonSerializable;

class TransactionHistoryRequest implements JsonSerializable
{
    /**
     * @param string[]|null $productIds
     * @param ProductType[]|null $productTypes
     * @param string[]|null $subscriptionGroupIdentifiers
     */
    public function __construct(
        private readonly ?int $startDate = null,
        private readonly ?int $endDate = null,
        private readonly ?array $productIds = null,
        private readonly ?array $productTypes = null,
        private readonly ?Order $sort = null,
        private readonly ?array $subscriptionGroupIdentifiers = null,
        private readonly ?InAppOwnershipType $inAppOwnershipType = null,
        private readonly ?bool $revoked = null,
    ) {
    }

    /**
     * An optional start date of the timespan for the transaction history records you're requesting. The startDate must
     * precede the endDate if you specify both dates. To be included in results, the transaction's purchaseDate must be
     * equal to or greater than the startDate.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/startdate
     */
    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    /**
     * An optional end date of the timespan for the transaction history records you're requesting. Choose an endDate
     * that's later than the startDate if you specify both dates. Using an endDate in the future is valid. To be
     * included in results, the transaction's purchaseDate must be less than the endDate.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/enddate
     */
    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    /**
     * An optional filter that indicates the product identifier to include in the transaction history. Your query may
     * specify more than one productID.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/productid
     *
     * @return string[]|null
     */
    public function getProductIds(): ?array
    {
        return $this->productIds;
    }

    /**
     * An optional filter that indicates the product type to include in the transaction history. Your query may specify
     * more than one productType.
     *
     * @return ProductType[]|null
     */
    public function getProductTypes(): ?array
    {
        return $this->productTypes;
    }

    /**
     * An optional sort order for the transaction history records. The response sorts the transaction records by their
     * recently modified date. The default value is ASCENDING, so you receive the oldest records first.
     */
    public function getSort(): ?Order
    {
        return $this->sort;
    }

    /**
     * An optional filter that indicates the subscription group identifier to include in the transaction history. Your
     * query may specify more than one subscriptionGroupIdentifier.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/subscriptiongroupidentifier
     *
     * @return string[]|null
     */
    public function getSubscriptionGroupIdentifiers(): ?array
    {
        return $this->subscriptionGroupIdentifiers;
    }

    /**
     * An optional filter that limits the transaction history by the in-app ownership type.
     *
     * https://developer.apple.com/documentation/appstoreserverapi/inappownershiptype
     */
    public function getInAppOwnershipType(): ?InAppOwnershipType
    {
        return $this->inAppOwnershipType;
    }

    /**
     * An optional Boolean value that indicates whether the response includes only revoked transactions when the value
     * is true, or contains only nonrevoked transactions when the value is false. By default, the request doesn't
     * include this parameter.
     */
    public function getRevoked(): ?bool
    {
        return $this->revoked;
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
