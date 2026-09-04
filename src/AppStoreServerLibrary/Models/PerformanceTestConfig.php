<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * An object that enumerates the test configuration parameters.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performancetestconfig
 */
class PerformanceTestConfig
{
    public function __construct(
        private readonly ?int $maxConcurrentRequests,
        private readonly ?int $totalRequests,
        private readonly ?int $totalDuration,
        private readonly ?int $responseTimeThreshold,
        private readonly ?int $successRateThreshold,
    ) {
    }

    /**
     * The maximum number of concurrent requests the API allows.
     *
     * https://developer.apple.com/documentation/retentionmessaging/maxconcurrentrequests
     */
    public function getMaxConcurrentRequests(): ?int
    {
        return $this->maxConcurrentRequests;
    }

    /**
     * The total number of requests to make during the test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/totalrequests
     */
    public function getTotalRequests(): ?int
    {
        return $this->totalRequests;
    }

    /**
     * The total duration of the test in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/totalduration
     */
    public function getTotalDuration(): ?int
    {
        return $this->totalDuration;
    }

    /**
     * The maximum time your server has to respond when the system calls your Get Retention Message endpoint in the
     * sandbox environment.
     *
     * https://developer.apple.com/documentation/retentionmessaging/responsetimethreshold
     */
    public function getResponseTimeThreshold(): ?int
    {
        return $this->responseTimeThreshold;
    }

    /**
     * The success rate threshold percentage.
     *
     * https://developer.apple.com/documentation/retentionmessaging/successratethreshold
     */
    public function getSuccessRateThreshold(): ?int
    {
        return $this->successRateThreshold;
    }

    public static function fromObject(stdClass $obj): PerformanceTestConfig
    {
        return new PerformanceTestConfig(
            maxConcurrentRequests: property_exists($obj, "maxConcurrentRequests")
                && is_int($obj->maxConcurrentRequests)
                ? $obj->maxConcurrentRequests : null,
            totalRequests: property_exists($obj, "totalRequests") && is_int($obj->totalRequests)
                ? $obj->totalRequests : null,
            totalDuration: property_exists($obj, "totalDuration") && is_int($obj->totalDuration)
                ? $obj->totalDuration : null,
            responseTimeThreshold: property_exists($obj, "responseTimeThreshold")
                && is_int($obj->responseTimeThreshold)
                ? $obj->responseTimeThreshold : null,
            successRateThreshold: property_exists($obj, "successRateThreshold")
                && is_int($obj->successRateThreshold)
                ? $obj->successRateThreshold : null,
        );
    }
}
