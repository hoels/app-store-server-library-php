<?php

namespace AppStoreServerLibrary\Models;

use JsonSerializable;

/**
 * The promotional offer signature you generate using an earlier signature version.
 *
 * https://developer.apple.com/documentation/retentionmessaging/promotionaloffersignaturev1
 */
class PromotionalOfferSignatureV1 implements JsonSerializable
{
    public function __construct(
        private readonly string $encodedSignature,
        private readonly string $productId,
        private readonly string $nonce,
        private readonly int $timestamp,
        private readonly string $keyId,
        private readonly string $offerIdentifier,
        private readonly ?string $appAccountToken,
    ) {
    }

    /**
     * The Base64-encoded cryptographic signature you generate using the offer parameters.
     */
    public function getEncodedSignature(): string
    {
        return $this->encodedSignature;
    }

    /**
     * The subscription's product identifier.
     *
     * https://developer.apple.com/documentation/retentionmessaging/productid
     */
    public function getProductId(): string
    {
        return $this->productId;
    }

    /**
     * A one-time-use UUID antireplay value you generate.
     */
    public function getNonce(): string
    {
        return $this->nonce;
    }

    /**
     * The UNIX time, in milliseconds, when you generate the signature.
     */
    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    /**
     * A string that identifies the private key you use to generate the signature.
     */
    public function getKeyId(): string
    {
        return $this->keyId;
    }

    /**
     * The subscription offer identifier that you set up in App Store Connect.
     */
    public function getOfferIdentifier(): string
    {
        return $this->offerIdentifier;
    }

    /**
     * A UUID that you provide to associate with the transaction if the customer accepts the promotional offer.
     */
    public function getAppAccountToken(): ?string
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
                $array[$key] = $value instanceof JsonSerializable ? $value->jsonSerialize() : $value;
            }
        }

        return $array;
    }
}
