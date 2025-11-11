<?php

namespace Vendor\LaravelUssd\Gateways;

use Illuminate\Http\Request;

/**
 * Generic request adapter for standard USSD gateway formats.
 *
 * Assumes the gateway sends requests with standard field names:
 * - sessionId: Session identifier
 * - msisdn: Phone number
 * - serviceCode: USSD service code (e.g., *123#)
 * - text: User input
 */
class GenericAdapter implements RequestAdapterInterface
{
    /**
     * Convert request to standard payload format.
     *
     * @param Request $request HTTP request
     * @return array Normalized payload
     */
    public function toPayload(Request $request): array
    {
        return [
            'sessionId' => $request->input('sessionId'),
            'msisdn' => $request->input('msisdn'),
            'serviceCode' => $request->input('serviceCode'),
            'input' => $request->input('text', ''),
        ];
    }
}
