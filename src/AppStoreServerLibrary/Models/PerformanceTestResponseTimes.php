<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * An object that describes test response times.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performancetestresponsetimes
 */
class PerformanceTestResponseTimes
{
    public function __construct(
        private readonly ?int $average,
        private readonly ?int $p50,
        private readonly ?int $p90,
        private readonly ?int $p95,
        private readonly ?int $p99,
    ) {
    }

    /**
     * Average response time in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/average
     */
    public function getAverage(): ?int
    {
        return $this->average;
    }

    /**
     * The 50th percentile response time in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/p50
     */
    public function getP50(): ?int
    {
        return $this->p50;
    }

    /**
     * The 90th percentile response time in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/p90
     */
    public function getP90(): ?int
    {
        return $this->p90;
    }

    /**
     * The 95th percentile response time in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/p95
     */
    public function getP95(): ?int
    {
        return $this->p95;
    }

    /**
     * The 99th percentile response time in milliseconds.
     *
     * https://developer.apple.com/documentation/retentionmessaging/p99
     */
    public function getP99(): ?int
    {
        return $this->p99;
    }

    public static function fromObject(stdClass $obj): PerformanceTestResponseTimes
    {
        return new PerformanceTestResponseTimes(
            average: property_exists($obj, "average") && is_int($obj->average)
                ? $obj->average : null,
            p50: property_exists($obj, "p50") && is_int($obj->p50)
                ? $obj->p50 : null,
            p90: property_exists($obj, "p90") && is_int($obj->p90)
                ? $obj->p90 : null,
            p95: property_exists($obj, "p95") && is_int($obj->p95)
                ? $obj->p95 : null,
            p99: property_exists($obj, "p99") && is_int($obj->p99)
                ? $obj->p99 : null,
        );
    }
}
