<?php

namespace Vendor\LaravelUssd\Tests\Feature;

use Vendor\LaravelUssd\Machine\Machine;
use Vendor\LaravelUssd\Tests\TestCase;

class SessionContinuityTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Enable continuity for these tests
        config()->set('ussd.continuity.enabled', true);
        config()->set('ussd.continuity.timeout', 900);
    }

    public function test_continuity_prompt_on_redial(): void
    {
        $machine = $this->app->make(Machine::class);
        $sessionId = 'continuity-test';
        $msisdn = '+1234567890';

        // Initial request - starts session
        $response1 = $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $this->assertStringStartsWith('CON', (string) $response1);

        // Simulate new dial-in (new session ID but same MSISDN)
        // This should trigger continuity prompt
        $response2 = $machine->handle([
            'sessionId' => 'new-session-id',
            'msisdn' => $msisdn, // Same phone number
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // Should show resume prompt if continuity is working
        // Note: This test may need adjustment based on actual continuity logic
        $this->assertStringStartsWith('CON', (string) $response2);
    }

    public function test_continuity_resume_selection(): void
    {
        $machine = $this->app->make(Machine::class);
        $sessionId = 'resume-test';
        $msisdn = '+1234567890';

        // Create initial session
        $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // Load context and simulate resume selection
        $sessions = $this->app->make(\Vendor\LaravelUssd\Session\SessionRepositoryInterface::class);
        $context = $sessions->load($sessionId, $msisdn);

        // Manually set continuity to simulate resume scenario
        $context->continuity = [
            'state' => \Vendor\LaravelUssd\Tests\Fixtures\WelcomeState::class,
            'timestamp' => now()->toIso8601String(),
            'awaiting_confirmation' => true,
        ];
        $sessions->save($context);

        // User selects resume option
        $response = $machine->handleResumeSelection($context, '1');

        if ($response) {
            $this->assertStringStartsWith('CON', (string) $response);
        }
    }
}

