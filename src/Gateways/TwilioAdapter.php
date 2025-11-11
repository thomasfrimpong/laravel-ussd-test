<?php

namespace Vendor\LaravelUssd\Gateways;

use Illuminate\Http\Request;

/**
 * Request adapter for Twilio USSD gateway.
 *
 * Twilio uses different field names:
 * - CallSid: Session identifier
 * - From: Phone number
 * - To: Service code
 * - Digits: User input
 */
class TwilioAdapter implements RequestAdapterInterface
{
    /**
     * Convert Twilio request to standard payload format.
     *
     * @param Request $request HTTP request from Twilio
     * @return array Normalized payload
     */
    public function toPayload(Request $request): array
    {
        return [
            'sessionId' => $request->input('CallSid'), // Twilio uses CallSid
            'msisdn' => $request->input('From'), // Twilio uses From
            'serviceCode' => $request->input('To'), // Twilio uses To
            'input' => $request->input('Digits', ''), // Twilio uses Digits
        ];
    }
}
