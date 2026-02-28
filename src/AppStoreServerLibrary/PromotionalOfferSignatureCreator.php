<?php

namespace AppStoreServerLibrary;

use Exception;
use OpenSSLAsymmetricKey;

class PromotionalOfferSignatureCreator
{
    private readonly OpenSSLAsymmetricKey $signingKey;


    /**
     * @throws Exception
     */
    public function __construct(
        string $signingKey,
        private readonly string $keyId,
        private readonly string $bundleId,
    ) {
        $signingKey = openssl_pkey_get_private($signingKey);
        if ($signingKey === false) {
            throw new Exception("Invalid key.");
        }
        $this->signingKey = $signingKey;
    }

    /**
     * Return the Base64 encoded signature
     *
     * https://developer.apple.com/documentation/storekit/in-app_purchase/original_api_for_in-app_purchase/subscriptions_and_offers/generating_a_signature_for_promotional_offers
     *
     * @param string $productIdentifier The subscription product identifier
     * @param string $subscriptionOfferId The subscription discount identifier
     * @param string $applicationUsername An optional string value that you define; may be an empty string
     * @param string $nonce A one-time UUID value that your server generates. Generate a new nonce for every signature.
     * @param int $timestamp A timestamp your server generates in UNIX time format, in milliseconds. The timestamp keeps
     * the offer active for 24 hours.
     * @return string The Base64 encoded signature
     */
    public function createSignature(
        string $productIdentifier,
        string $subscriptionOfferId,
        string $applicationUsername,
        string $nonce,
        int $timestamp
    ): string {
        $payload = $this->bundleId . mb_chr(0x2063)
            . $this->keyId . mb_chr(0x2063)
            . $productIdentifier . mb_chr(0x2063)
            . $subscriptionOfferId . mb_chr(0x2063)
            . strtolower($applicationUsername) . mb_chr(0x2063)
            . strtolower($nonce) . mb_chr(0x2063)
            . $timestamp;
        openssl_sign($payload, $signature, $this->signingKey, algorithm: OPENSSL_ALGO_SHA256);
        /** @var string $signature */
        return base64_encode($signature);
    }
}
