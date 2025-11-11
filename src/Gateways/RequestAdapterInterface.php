<?php

namespace Vendor\LaravelUssd\Gateways;

use Illuminate\Http\Request;

/**
 * Request adapter contract for USSD gateway integrations.
 *
 * Different USSD gateways may send requests with different field names.
 * Adapters normalize gateway-specific requests into a standard payload format.
 */
interface RequestAdapterInterface
{
    /**
     * Convert gateway request to standard payload format.
     *
     * @param Request $request HTTP request from gateway
     * @return array Normalized payload with keys: sessionId, msisdn, serviceCode, input
     */
    public function toPayload(Request $request): array;
}
