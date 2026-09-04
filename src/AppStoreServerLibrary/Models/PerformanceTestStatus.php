<?php

namespace AppStoreServerLibrary\Models;

/**
 * The status of the performance test.
 *
 * https://developer.apple.com/documentation/retentionmessaging/performanceteststatus
 */
enum PerformanceTestStatus: string
{
    case PENDING = "PENDING";
    case PASS = "PASS";
    case FAIL = "FAIL";
}
