<?php

namespace AppStoreServerLibrary;

use Firebase\JWT\JWT;

abstract class JWSSignatureCreator
{
    protected function __construct(
        protected readonly string $audience,
        protected readonly string $signingKey,
        protected readonly string $keyId,
        protected readonly string $issuerId,
        protected readonly string $bundleId,
    ) {
    }

    /**
     * @param array<string, mixed> $featureSpecificClaims
     */
    protected function createSignatureFromClaims(array $featureSpecificClaims): string
    {
        return JWT::encode(
            payload: [
                ...$featureSpecificClaims,
                "bid" => $this->bundleId,
                "iss" => $this->issuerId,
                "aud" => $this->audience,
                "iat" => time(),
                "nonce" => JWSSignatureCreator::uuidv4(),
            ],
            key: $this->signingKey,
            alg: "ES256",
            keyId: $this->keyId
        );
    }

    private static function uuidv4(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
