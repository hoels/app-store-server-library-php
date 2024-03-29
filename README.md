# (Unofficial) Apple App Store Server PHP Library
The **unofficial** PHP server library for the
[App Store Server API](https://developer.apple.com/documentation/appstoreserverapi) and
[App Store Server Notifications](https://developer.apple.com/documentation/appstoreservernotifications).
Also available in
[Swift](https://github.com/apple/app-store-server-library-swift),
[Python](https://github.com/apple/app-store-server-library-python),
[Node.js](https://github.com/apple/app-store-server-library-node), and
[Java](https://github.com/apple/app-store-server-library-java).

## Table of Contents
1. [Author](#author)
2. [Installation](#installation)
3. [Documentation](#documentation)
4. [Usage](#usage)
5. [Support](#support)

## Author

I am NOT associated with Apple in any way. I am an app developer and IT security specialist who developed this library
because Apple does not offer a dedicated PHP library. Not offering a native and secure library leads to insecure
third-party implementations imho. Therefore, this library is intended to mirror the native Apple libraries as closely as
possible. Most of the functionality is an exact copy of Apple's Python library, with some PHP-specific modifications and
influences from Apple's Swift library. I intend to keep this library and its major versions up-to-date with the Apple
libraries.

## Installation

#### Requirements

- PHP 8.1+
- OpenSSL and JSON PHP Extension
- Composer

### Composer
```shell
composer require hoels/app-store-server-library-php
```

## Documentation

[Documentation of Python Library](https://apple.github.io/app-store-server-library-python/)

[WWDC Video](https://developer.apple.com/videos/play/wwdc2023/10143/)

### Obtaining an In-App Purchase key from App Store Connect

To use the App Store Server API or create promotional offer signatures, a signing key downloaded from App Store Connect
is required. To obtain this key, you must have the Admin role. Go to Users and Access > Integrations > In-App Purchase.
Here you can create and manage keys, as well as find your issuer ID. When using a key, you'll need the key ID and
issuer ID as well.

### Obtaining Apple Root Certificates

Download and store the root certificates found in the Apple Root Certificates section of the
[Apple PKI](https://www.apple.com/certificateauthority/) site. Provide these certificates as an array to a
SignedDataVerifier to allow verifying the signed data coming from Apple.

## Usage

### API Usage

```php
use AppStoreServerLibrary\AppStoreServerAPIClient;
use AppStoreServerLibrary\AppStoreServerAPIClient\APIException;
use AppStoreServerLibrary\Models\Environment;

$privateKey = file_get_contents("/path/to/key/SubscriptionKey_ABCDEFGHIJ.p8"); // Implementation will vary

$keyId = "ABCDEFGHIJ";
$issuerId = "99b16628-15e4-4668-972b-eeff55eeff55";
$bundleId = "com.example";
$environment = Environment::SANDBOX;

$client = new AppStoreServerAPIClient(
    signingKey: $privateKey,
    keyId: $keyId,
    issuerId: $issuerId,
    bundleId: $bundleId,
    environment: $environment
);

try {
    $response = $client->requestTestNotification();
    print_r($response);
} catch (APIException $e) {
    print_r($e);
}
```

### Verification Usage

```php
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\SignedDataVerifier;
use AppStoreServerLibrary\SignedDataVerifier\VerificationException;

$rootCertificates = load_root_certificates(); // Implementation will vary
$enableOnlineChecks = true;
$bundleId = "com.example";
$environment = Environment::SANDBOX;
$appAppleId = null; // appAppleId must be provided for the Production environment
$signedDataVerifier = new SignedDataVerifier(
    rootCertificates: $rootCertificates,
    enableOnlineChecks: $enableOnlineChecks,
    environment: $environment,
    bundleId: $bundleId,
    appAppleId: $appAppleId
);

try {
    $signedNotification = "ey..";
    $payload = $signedDataVerifier->verifyAndDecodeNotification($signedNotification);
    print_r($payload);
} catch (VerificationException $e) {
    print_r($e);
}
```

### Receipt Usage

```php
use AppStoreServerLibrary\AppStoreServerAPIClient;
use AppStoreServerLibrary\AppStoreServerAPIClient\APIException;
use AppStoreServerLibrary\Models\Environment;
use AppStoreServerLibrary\Models\TransactionHistoryRequest;
use AppStoreServerLibrary\Models\TransactionHistoryRequest\Order;
use AppStoreServerLibrary\Models\TransactionHistoryRequest\ProductType;
use AppStoreServerLibrary\ReceiptUtility;

$privateKey = file_get_contents("/path/to/key/SubscriptionKey_ABCDEFGHIJ.p8"); // Implementation will vary

$keyId = "ABCDEFGHIJ";
$issuerId = "99b16628-15e4-4668-972b-eeff55eeff55";
$bundleId = "com.example";
$environment = Environment::SANDBOX;

$client = new AppStoreServerAPIClient(
    signingKey: $privateKey,
    keyId: $keyId,
    issuerId: $issuerId,
    bundleId: $bundleId,
    environment: $environment
);
$receiptUtility = new ReceiptUtility();
$appReceipt = "MI..";

try {
    $transactionId = $receiptUtility->extractTransactionIdFromAppReceipt($appReceipt);
    if ($transactionId !== null) {
        $transactions = [];
        $response = null;
        $request = new TransactionHistoryRequest(
            sort: Order::ASCENDING,
            revoked: false,
            productTypes: [ProductType::AUTO_RENEWABLE]
        );
        while ($response === null || $response->getHasMore() === true) {
            $revision = $response?->getRevision();
            $response = $client->getTransactionHistory(
                transactionId: $transactionId,
                revision: $revision,
                transactionHistoryRequest: $request
            );
            foreach ($response->getSignedTransactions() as $transaction) {
                $transactions[] = $transaction;
            }
        }
        print_r($transactions);
    }
} catch (APIException $e) {
    print_r($e);
}
```

### Promotional Offer Signature Creation

```php
use AppStoreServerLibrary\PromotionalOfferSignatureCreator;

$privateKey = file_get_contents("/path/to/key/SubscriptionKey_ABCDEFGHIJ.p8"); // Implementation will vary

$keyId = "ABCDEFGHIJ";
$bundleId = "com.example";

$promotionalOfferSignatureCreator = new PromotionalOfferSignatureCreator(
    signingKey: $privateKey,
    keyId: $keyId,
    bundleId: $bundleId
);

$productId = "<product_id>";
$subscriptionOfferId = "<subscription_offer_id>";
$applicationUsername = "<application_username>";
$nonce = "<nonce>";
$timestamp = time() * 1000;
$base64EncodedSignature = $promotionalOfferSignatureCreator->createSignature(
    productIdentifier: $productId,
    subscriptionOfferId: $subscriptionOfferId,
    applicationUsername: $applicationUsername,
    nonce: $nonce,
    timestamp: $timestamp
);
```

## Support

Only the latest major version of the library will receive updates, including security updates. Therefore, it is
recommended to update to new major versions.
