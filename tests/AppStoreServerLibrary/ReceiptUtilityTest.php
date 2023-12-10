<?php

namespace AppStoreServerLibrary\Tests;

use AppStoreServerLibrary\ReceiptUtility;
use PHPUnit\Framework\TestCase;

class ReceiptUtilityTest extends TestCase
{
    public function testXcodeAppReceiptExtractionWithNoTransactions(): void
    {
        $receipt = file_get_contents(__DIR__ . "/resources/xcode/xcode-app-receipt-empty");
        $receiptUtil = new ReceiptUtility();
        $extractedTransactionId = $receiptUtil->extractTransactionIdFromAppReceipt($receipt);
        self::assertNull($extractedTransactionId);
    }

    public function testXcodeAppReceiptExtractionWithTransactions(): void
    {
        $receipt = file_get_contents(__DIR__ . "/resources/xcode/xcode-app-receipt-with-transaction");
        $receiptUtil = new ReceiptUtility();
        $extractedTransactionId = $receiptUtil->extractTransactionIdFromAppReceipt($receipt);
        self::assertEquals("0", $extractedTransactionId);
    }

    public function testTransactionReceiptExtraction(): void
    {
        $receipt = file_get_contents(__DIR__ . "/resources/mock_signed_data/legacyTransaction");
        $receiptUtil = new ReceiptUtility();
        $extractedTransactionId = $receiptUtil->extractTransactionIdFromTransactionReceipt($receipt);
        self::assertEquals("33993399", $extractedTransactionId);
    }
}
