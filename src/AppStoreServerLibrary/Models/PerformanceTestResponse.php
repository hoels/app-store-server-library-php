<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * The performance test response object.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performancetestresponse
 */
class PerformanceTestResponse
{
    public function __construct(
        private readonly ?PerformanceTestConfig $config,
        private readonly ?string $requestId,
    ) {
    }

    /**
     * The performance test configuration object.
     *
     * https://developer.apple.com/documentation/retentionmessaging/performancetestconfig
     */
    public function getConfig(): ?PerformanceTestConfig
    {
        return $this->config;
    }

    /**
     * The performance test request identifier.
     *
     * https://developer.apple.com/documentation/retentionmessaging/requestid
     */
    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public static function fromObject(stdClass $obj): PerformanceTestResponse
    {
        return new PerformanceTestResponse(
            config: property_exists($obj, "config")
                && ($obj->config instanceof stdClass || is_array($obj->config))
                ? PerformanceTestConfig::fromObject((object)$obj->config) : null,
            requestId: property_exists($obj, "requestId") && is_string($obj->requestId)
                ? $obj->requestId : null,
        );
    }
}
