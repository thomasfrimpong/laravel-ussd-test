<?php

namespace Vendor\LaravelUssd\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to normalize USSD request payloads.
 *
 * Different USSD gateways may use different field names for the same data.
 * This middleware standardizes the request payload to use consistent field names.
 */
class NormalizeUssdRequest
{
    /**
     * Handle incoming request and normalize payload.
     *
     * Merges alternative field names into standard field names:
     * - sessionId/session_id -> sessionId
     * - msisdn/phoneNumber -> msisdn
     * - text -> text (ensures it exists)
     *
     * @param Request $request HTTP request
     * @param Closure $next Next middleware handler
     * @return mixed Response
     */
    public function handle(Request $request, Closure $next)
    {
        // Normalize field names to support multiple gateway formats
        $request->merge([
            'sessionId' => $request->input('sessionId') ?? $request->input('session_id'),
            'msisdn' => $request->input('msisdn') ?? $request->input('phoneNumber'),
            'text' => $request->input('text', ''),
        ]);

        return $next($request);
    }
}
