<?php

namespace AppStoreServerLibrary\Tests\JWSSignatureCreatorTest;

use AppStoreServerLibrary\Models\AdvancedCommerceAPIInAppRequest;

class TestInAppRequest extends AdvancedCommerceAPIInAppRequest
{
    public function __construct(
        public string $testValue,
    ) {
    }
}
