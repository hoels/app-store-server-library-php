<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The request body that contains an app account token value.
 *
 * https://developer.apple.com/documentation/appstoreserverapi/updateappaccounttokenrequest
 */
class UpdateAppAccountTokenRequest implements JsonSerializable
{
    public function __construct(
        private readonly string $appAccountToken,
    ) {
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
