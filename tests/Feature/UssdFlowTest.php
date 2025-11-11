<?php

namespace Vendor\LaravelUssd\Tests\Feature;

use Vendor\LaravelUssd\Machine\Machine;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Tests\TestCase;

class UssdFlowTest extends TestCase
{
    public function test_it_loads_initial_state(): void
    {
        $machine = $this->app->make(Machine::class);

        $response = $machine->handle([
            'sessionId' => 'test-session-123',
            'msisdn' => '+1234567890',
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $this->assertInstanceOf(UssdResponse::class, $response);
        $this->assertStringStartsWith('CON', (string) $response);
        $this->assertStringContainsString('Welcome test menu', (string) $response);
    }

    public function test_it_processes_user_input(): void
    {
        $machine = $this->app->make(Machine::class);

        // Initial request
        $response1 = $machine->handle([
            'sessionId' => 'test-session-456',
            'msisdn' => '+1234567890',
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $this->assertStringStartsWith('CON', (string) $response1);

        // User selects option 1
        $response2 = $machine->handle([
            'sessionId' => 'test-session-456',
            'msisdn' => '+1234567890',
            'serviceCode' => '*123#',
            'input' => '1',
        ]);

        // Should end session since WelcomeState returns null
        $this->assertStringStartsWith('END', (string) $response2);
    }

    public function test_session_persistence(): void
    {
        $machine = $this->app->make(Machine::class);
        $sessionId = 'persistent-session';
        $msisdn = '+1234567890';

        // First request
        $response1 = $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // Second request with same session should maintain state
        $response2 = $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $this->assertStringStartsWith('CON', (string) $response1);
        $this->assertStringStartsWith('CON', (string) $response2);
    }
}
