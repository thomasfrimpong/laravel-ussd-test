<?php

namespace Vendor\LaravelUssd\Tests\Feature;

use Vendor\LaravelUssd\Machine\Machine;
use Vendor\LaravelUssd\Session\SessionRepositoryInterface;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Tests\Fixtures\AgeState;
use Vendor\LaravelUssd\Tests\Fixtures\NameState;
use Vendor\LaravelUssd\Tests\TestCase;

class SessionContinuityTest extends TestCase
{
    protected string $msisdn = '+1234567890';

    protected function setUp(): void
    {
        parent::setUp();

        // Use the multi-step fixture flow so we can verify data is preserved.
        config()->set('ussd.initial_state', NameState::class);

        // Enable continuity for these tests.
        config()->set('ussd.continuity.enabled', true);
        config()->set('ussd.continuity.timeout', 900);

        // Allow immediate redials in tests (production guards against showing the
        // prompt for same-session empty input via resume_min_age).
        config()->set('ussd.continuity.resume_min_age', 0);
    }

    protected function machine(): Machine
    {
        return $this->app->make(Machine::class);
    }

    protected function sessions(): SessionRepositoryInterface
    {
        return $this->app->make(SessionRepositoryInterface::class);
    }

    /**
     * Dial in and advance into the second state, collecting the name, then
     * abandon the session (no completion).
     */
    protected function startAndAbandon(string $sessionId): void
    {
        $machine = $this->machine();

        $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // Provide the name -> advances to AgeState (and persists continuity).
        $machine->handle([
            'sessionId' => $sessionId,
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => 'John',
        ]);
    }

    public function test_continuity_prompt_on_redial(): void
    {
        $this->startAndAbandon('session-A');

        // Redial with a brand-new session ID (as a gateway would issue after a
        // cancel/timeout/crash), same phone number.
        $response = $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $text = (string) $response;

        $this->assertStringStartsWith('CON', $text);
        $this->assertStringContainsString(config('ussd.continuity.resume_prompt'), $text);
        $this->assertStringContainsString(config('ussd.continuity.resume_option_text'), $text);
        $this->assertStringContainsString(config('ussd.continuity.restart_option_text'), $text);
    }

    public function test_resume_restores_state_and_data(): void
    {
        $this->startAndAbandon('session-A');

        // Redial -> shows the resume prompt.
        $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // User chooses to resume.
        $response = $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => config('ussd.continuity.resume_option_key'),
        ]);

        $text = (string) $response;

        // Should land back on the state where the user left off.
        $this->assertStringStartsWith('CON', $text);
        $this->assertStringContainsString('Enter your age', $text);

        // The previously collected data must be preserved.
        $context = $this->sessions()->load('session-B', $this->msisdn);
        $this->assertSame(AgeState::class, $context->currentState);
        $this->assertSame('John', $context->data['name'] ?? null);
    }

    public function test_restart_clears_previous_progress(): void
    {
        $this->startAndAbandon('session-A');

        // Redial -> shows the resume prompt.
        $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        // User chooses to start over.
        $response = $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => config('ussd.continuity.restart_option_key'),
        ]);

        $text = (string) $response;

        // Should land on the initial state with the previous data cleared.
        $this->assertStringStartsWith('CON', $text);
        $this->assertStringContainsString('Enter your name', $text);

        $context = $this->sessions()->load('session-B', $this->msisdn);
        $this->assertSame(NameState::class, $context->currentState);
        $this->assertArrayNotHasKey('name', $context->data);
    }

    public function test_completed_session_does_not_offer_resume(): void
    {
        $machine = $this->machine();

        // Drive the flow to completion.
        $machine->handle([
            'sessionId' => 'session-A',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);
        $machine->handle([
            'sessionId' => 'session-A',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => 'John',
        ]);
        $end = $machine->handle([
            'sessionId' => 'session-A',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '25',
        ]);

        $this->assertStringStartsWith('END', (string) $end);

        // Redial: the finished session must not be offered for resume.
        $response = $this->machine()->handle([
            'sessionId' => 'session-B',
            'msisdn' => $this->msisdn,
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $text = (string) $response;

        $this->assertStringStartsWith('CON', $text);
        $this->assertStringContainsString('Enter your name', $text);
        $this->assertStringNotContainsString(config('ussd.continuity.resume_prompt'), $text);
    }
}
