<?php

namespace Vendor\LaravelUssd\Http\Controllers;

use Illuminate\Http\Request;
use Vendor\LaravelUssd\Machine\Machine;
use Vendor\LaravelUssd\Session\SessionRepositoryInterface;
use Vendor\LaravelUssd\Support\Context;
use function response;

/**
 * USSD request controller.
 *
 * Handles incoming HTTP requests from USSD gateways and routes them
 * through the Machine orchestrator. Supports session continuity by
 * checking for resume selections before processing normal flow.
 */
class UssdController
{
    /**
     * Create a new USSD controller instance.
     *
     * @param Machine $machine Machine orchestrator for processing requests
     * @param SessionRepositoryInterface $sessions Session repository for loading contexts
     */
    public function __construct(protected Machine $machine, protected SessionRepositoryInterface $sessions)
    {
    }

    /**
     * Handle incoming USSD request.
     *
     * Normalizes request payload, loads session context, checks for resume
     * selection, and processes through the machine.
     *
     * @param Request $request HTTP request from USSD gateway
     * @return \Illuminate\Http\Response HTTP response with USSD payload
     */
    public function __invoke(Request $request)
    {
        // Normalize payload - support multiple gateway formats
        $payload = [
            'sessionId' => $request->input('sessionId') ?? $request->input('session_id'),
            'msisdn' => $request->input('msisdn') ?? $request->input('phoneNumber'),
            'serviceCode' => $request->input('serviceCode'),
            'input' => $request->input('text', ''),
        ];

        // Load session context
        $context = $this->sessions->load($payload['sessionId'], $payload['msisdn']);

        // Check if user is responding to resume prompt
        if ($response = $this->machine->handleResumeSelection($context, $payload['input'])) {
            return response((string) $response);
        }

        // Process normal flow
        $response = $this->machine->handle($payload);

        return response((string) $response);
    }
}
