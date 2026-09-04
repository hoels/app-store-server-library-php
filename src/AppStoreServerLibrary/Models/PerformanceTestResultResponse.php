<?php

namespace AppStoreServerLibrary\Models;

use stdClass;

/**
 * An object the API returns that describes the performance test results.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performancetestresultresponse
 */
class PerformanceTestResultResponse
{
    /**
     * @param array<string, int>|null $failures
     */
    public function __construct(
        private readonly ?PerformanceTestConfig $config,
        private readonly ?string $target,
        private readonly ?PerformanceTestStatus $result,
        private readonly ?int $successRate,
        private readonly ?int $numPending,
        private readonly ?PerformanceTestResponseTimes $responseTimes,
        private readonly ?array $failures,
    ) {
    }

    /**
     * A PerformanceTestConfig object that enumerates the test parameters.
     *
     * https://developer.apple.com/documentation/retentionmessaging/performancetestconfig
     */
    public function getConfig(): ?PerformanceTestConfig
    {
        return $this->config;
    }

    /**
     * The target URL for the performance test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/target
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    /**
     * A PerformanceTestStatus object that describes the overall result of the test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/performanceteststatus
     */
    public function getResult(): ?PerformanceTestStatus
    {
        return $this->result;
    }

    /**
     * An integer that describes he success rate percentage of the performance test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/successrate
     */
    public function getSuccessRate(): ?int
    {
        return $this->successRate;
    }

    /**
     * An integer that describes the number of pending requests in the performance test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/numpending
     */
    public function getNumPending(): ?int
    {
        return $this->numPending;
    }

    /**
     * A PerformanceTestResponseTimes object that enumerates the response times measured during the test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/performancetestresponsetimes
     */
    public function getResponseTimes(): ?PerformanceTestResponseTimes
    {
        return $this->responseTimes;
    }

    /**
     * A map of server-to-server notification failure reasons and counts that represent the number of failures
     * encountered during the performance test.
     *
     * https://developer.apple.com/documentation/retentionmessaging/failures
     *
     * @return array<string, int>|null
     */
    public function getFailures(): ?array
    {
        return $this->failures;
    }

    /**
     * @param mixed[] $failuresRaw
     * @return array<string, int>
     */
    private static function parseFailures(array $failuresRaw): array
    {
        $failures = [];
        foreach ($failuresRaw as $sendAttemptResultRaw => $count) {
            if (is_string($sendAttemptResultRaw)
                && ($sendAttemptResult = SendAttemptResult::tryFrom($sendAttemptResultRaw)) !== null
                && is_int($count)
            ) {
                $failures[$sendAttemptResult->value] = $count;
            }
        }
        return $failures;
    }

    public static function fromObject(stdClass $obj): PerformanceTestResultResponse
    {
        return new PerformanceTestResultResponse(
            config: property_exists($obj, "config")
                && ($obj->config instanceof stdClass || is_array($obj->config))
                ? PerformanceTestConfig::fromObject((object)$obj->config) : null,
            target: property_exists($obj, "target") && is_string($obj->target)
                ? $obj->target : null,
            result: property_exists($obj, "result") && is_string($obj->result)
                ? PerformanceTestStatus::tryFrom($obj->result) : null,
            successRate: property_exists($obj, "successRate") && is_int($obj->successRate)
                ? $obj->successRate : null,
            numPending: property_exists($obj, "numPending") && is_int($obj->numPending)
                ? $obj->numPending : null,
            responseTimes: property_exists($obj, "responseTimes")
                && ($obj->responseTimes instanceof stdClass || is_array($obj->responseTimes))
                ? PerformanceTestResponseTimes::fromObject((object)$obj->responseTimes) : null,
            failures: property_exists($obj, "failures") && is_array($obj->failures)
                ? self::parseFailures($obj->failures) : null,
        );
    }
}
