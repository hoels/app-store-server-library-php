<?php

namespace AppStoreServerLibrary;

use phpseclib3\File\ASN1;
use phpseclib3\Math\BigInteger;
use ValueError;

class ReceiptUtility
{
    const PKCS7_OID = "1.2.840.113549.1.7.2";
    const IN_APP_ARRAY = 17;
    const TRANSACTION_IDENTIFIER = 1703;


    /**
     * Extracts a transaction id from an encoded App Receipt. Throws if the receipt does not match the expected format.
     * *NO validation* is performed on the receipt, and any data returned should only be used to call the App Store
     * Server API.
     *
     * @param string $appReceipt The unmodified app receipt
     * @return string|null A transaction id from the array of in-app purchases, null if the receipt contains no in-app
     * purchases
     * @throws ValueError
     */
    public function extractTransactionIdFromAppReceipt(string $appReceipt): ?string
    {
        $decodedArray = ASN1::decodeBER(base64_decode($appReceipt));
        $current = $decodedArray[0] ?? null;
        $type = $current["type"] ?? null;
        if ($type !== ASN1::TYPE_SEQUENCE) {
            throw new ValueError();
        }

        # PKCS#7 object
        $currentRead = $current["content"][0] ?? null;
        $type = $currentRead["type"] ?? null;
        $value = $currentRead["content"] ?? null;
        if ($type !== ASN1::TYPE_OBJECT_IDENTIFIER || $value !== self::PKCS7_OID) {
            throw new ValueError();
        }

        // This is the PKCS#7 format, work our way into the inner content
        $current = $current["content"][1] ?? null; // decoder.read()  decoder.enter()
        $current = $current["content"][0] ?? null; // decoder.enter()
        $current = $current["content"][2] ?? null; // decoder.read()  decoder.read()  decoder.enter()
        $current = $current["content"][1] ?? null; // decoder.read()  decoder.enter()
        $currentRead = $current["content"][0] ?? null;
        $type = $currentRead["type"] ?? null;
        $value = $currentRead["content"] ?? null;

        // Xcode uses nested OctetStrings, we extract the inner string in this case
        if ($type !== ASN1::TYPE_OCTET_STRING) {
            throw new ValueError();
        }
        $decodedArray = ASN1::decodeBER($value);
        $current = $decodedArray[0] ?? null;
        $type = $current["type"] ?? null;
        if ($type !== ASN1::TYPE_SET) {
            throw new ValueError();
        }

        // We are in the top-level sequence, work our way to the array of in-apps
        foreach ($current["content"] ?? [] as $loopCurrent) {
            $currentRead = $loopCurrent["content"][0] ?? null;
            $type = $currentRead["type"] ?? null;
            $value = $currentRead["content"] ?? null;
            if ($type === ASN1::TYPE_INTEGER
                && ($value === self::IN_APP_ARRAY
                    || ($value instanceof BigInteger && $value->compare(new BigInteger(self::IN_APP_ARRAY)) === 0))
            ) {
                $currentRead = $loopCurrent["content"][2] ?? null;
                $type = $currentRead["type"] ?? null;
                $value = $currentRead["content"] ?? null;
                if ($type !== ASN1::TYPE_OCTET_STRING) {
                    throw new ValueError();
                }

                // In-app array
                $decodedArray = ASN1::decodeBER($value);
                $currentInApp = $decodedArray[0] ?? null;
                foreach ($currentInApp["content"] ?? null as $loopCurrentInApp) {
                    $currentRead = $loopCurrentInApp["content"][0] ?? null;
                    $type = $currentRead["type"] ?? null;
                    $value = $currentRead["content"] ?? null;
                    if ($type === ASN1::TYPE_INTEGER
                        && ($value === self::TRANSACTION_IDENTIFIER
                            || ($value instanceof BigInteger
                                && $value->compare(new BigInteger(self::TRANSACTION_IDENTIFIER)) === 0))
                    ) {
                        $currentRead = $loopCurrentInApp["content"][2] ?? null;
                        $type = $currentRead["type"] ?? null;
                        $value = $currentRead["content"] ?? null;
                        if ($type !== ASN1::TYPE_OCTET_STRING) {
                            throw new ValueError();
                        }
                        $decodedArray = ASN1::decodeBER($value);
                        return $decodedArray[0]["content"] ?? null;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Extracts a transaction id from an encoded transactional receipt. Throws if the receipt does not match the
     * expected format.
     * *NO validation* is performed on the receipt, and any data returned should only be used to call the App Store
     * Server API.
     *
     * @param string $transactionReceipt The unmodified transactionReceipt
     * @return string|null A transaction id, or null if no transactionId is found in the receipt
     */
    public function extractTransactionIdFromTransactionReceipt(string $transactionReceipt): ?string
    {
        $decodedTopLevel = base64_decode($transactionReceipt);
        $pattern = '/"purchase-info"\s+=\s+"([a-zA-Z0-9+\/=]+)"/';
        if ($decodedTopLevel !== false && preg_match($pattern, $decodedTopLevel, $matchingResult) === 1) {
            $decodedInnerLevel = base64_decode($matchingResult[1]);
            $pattern = '/"transaction-id"\s+=\s+"([a-zA-Z0-9+\/=]+)";/';
            if ($decodedInnerLevel !== false && preg_match($pattern, $decodedInnerLevel, $innerMatchingResult) === 1) {
                return $innerMatchingResult[1];
            }
        }
        return null;
    }
}
