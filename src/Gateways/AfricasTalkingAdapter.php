<?php

namespace Vendor\LaravelUssd\Gateways;

use Illuminate\Http\Request;

/**
 * Request adapter for Africa's Talking USSD gateway.
 *
 * Africa's Talking uses "phoneNumber" instead of "msisdn" for the phone number field.
 */
class AfricasTalkingAdapter implements RequestAdapterInterface
{
    /**
     * Convert Africa's Talking request to standard payload format.
     *
     * @param Request $request HTTP request from Africa's Talking
     * @return array Normalized payload
     */
    public function toPayload(Request $request): array
    {
        return [
            'sessionId' => $request->input('sessionId'),
            'msisdn' => $request->input('phoneNumber'), // Africa's Talking uses "phoneNumber"
            'serviceCode' => $request->input('serviceCode'),
            'input' => $request->input('text', ''),
        ];
    }
}
