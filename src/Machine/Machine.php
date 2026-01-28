<?php

namespace Vendor\LaravelUssd\Machine;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Vendor\LaravelUssd\Contracts\State;
use Vendor\LaravelUssd\Events\SessionResumed;
use Vendor\LaravelUssd\Events\SessionRestarted;
use Vendor\LaravelUssd\Events\StateEntered;
use Vendor\LaravelUssd\Events\StateExited;
use Vendor\LaravelUssd\Session\SessionRepositoryInterface;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;

/**
 * Machine orchestrator for USSD application flow.
 *
 * The Machine class is the central component that manages the entire USSD session lifecycle.
 * It handles state resolution, user input processing, session continuity, and state transitions.
 * It also dispatches events for state changes and session lifecycle events.
 */
class Machine
{
    /**
     * Create a new Machine instance.
     *
     * @param Container $container Laravel service container for resolving state classes
     * @param SessionRepositoryInterface $sessions Repository for persisting session data
     * @param Dispatcher $events Event dispatcher for emitting lifecycle events
     * @param ConfigRepository $config Configuration repository for accessing package settings
     */
    public function __construct(
        protected Container $container,
        protected SessionRepositoryInterface $sessions,
        protected Dispatcher $events,
        protected ConfigRepository $config
    ) {}

    /**
     * Handle incoming USSD request and process the flow.
     *
     * This method orchestrates the entire USSD session flow:
     * 1. Loads or creates session context
     * 2. Checks for session continuity (resume option)
     * 3. Resolves current state and processes user input
     * 4. Transitions to next state or ends session
     *
     * @param array $payload Request payload containing:
     *                      - sessionId: Unique session identifier
     *                      - msisdn: Phone number of the user
     *                      - input: User's input (empty string for initial request)
     * @return UssdResponse Formatted USSD response (CON or END)
     */
    public function handle(array $payload): UssdResponse
    {
        // Load existing session or create new context
        $context = $this->sessions->load($payload['sessionId'], $payload['msisdn']);

        // Check if we should offer session resume (only on initial request with no input)
        if ($this->shouldOfferResume($context) && empty($payload['input'])) {
            return $this->makeResumePrompt($context);
        }

        $input = $payload['input'] ?? '';

        // Resolve the current state class from the context
        $state = $this->resolveState($context->currentState);

        // Emit event when entering a state
        $this->events->dispatch(new StateEntered($context, $state::class));

        // If no input provided, this is an initial entry to the state
        if ($input === '') {
            // Update continuity metadata for potential resume
            $this->sessions->touchContinuity($context, $context->currentState);

            return $state->entry($context);
        }

        // Process user input and determine next state
        $next = $state->next($context, $input);

        // Emit event when exiting a state
        $this->events->dispatch(new StateExited($context, $state::class));

        // If next state is specified, transition to it
        if (is_string($next) && $next !== '') {
            $context->currentState = $next;
            $this->sessions->save($context);
            // Update continuity to track progress
            $this->sessions->touchContinuity($context, $next);

            return $this->resolveState($next)->entry($context);
        }

        // No next state means session is complete - clear session data
        $this->sessions->clear($context->sessionId, $context->msisdn);
        $this->sessions->clearContinuity($context);

        return UssdResponse::end('Thank you.');
    }

    /**
     * Determine if session resume should be offered to the user.
     *
     * Checks if continuity is enabled, exists, not already awaiting confirmation,
     * and is within the configured timeout period.
     *
     * @param Context $context Current session context
     * @return bool True if resume option should be offered
     */
    protected function shouldOfferResume(Context $context): bool
    {
        $config = $this->config->get('ussd.continuity', []);

        // Continuity must be enabled in configuration
        if (!($config['enabled'] ?? false)) {
            return false;
        }

        // Must have continuity metadata from previous session
        if (!$context->continuity) {
            return false;
        }

        // Don't offer if already awaiting user's resume/restart selection
        if ($context->continuity['awaiting_confirmation'] ?? false) {
            return false;
        }

        // Check if continuity data is still within timeout window
        $timeout = $config['timeout'] ?? 900; // Default: 15 minutes
        $timestamp = strtotime($context->continuity['timestamp'] ?? '');

        if (!$timestamp) {
            return false;
        }

        // Return true if within timeout period
        return (time() - $timestamp) <= $timeout;
    }

    /**
     * Generate and return the resume prompt menu.
     *
     * Marks the context as awaiting confirmation and saves it before returning the prompt.
     *
     * @param Context $context Current session context
     * @return UssdResponse CONTINUE response with resume/restart options
     */
    protected function makeResumePrompt(Context $context): UssdResponse
    {
        $config = $this->config->get('ussd.continuity', []);

        // Mark that we're awaiting user's selection
        $context->continuity['awaiting_confirmation'] = true;
        $this->sessions->save($context);

        return UssdResponse::continue($this->resumePromptMessage($config));
    }

    /**
     * Handle user's selection from the resume prompt.
     *
     * Processes the user's choice to either resume from previous state
     * or restart from the beginning. Returns null if not in resume selection mode.
     *
     * @param Context $context Current session context
     * @param string $input User's input (resume or restart option key)
     * @return UssdResponse|null Response for the selected option, or null if invalid state
     */
    public function handleResumeSelection(Context $context, string $input): ?UssdResponse
    {
        $config = $this->config->get('ussd.continuity', []);

        // Only process if we're actually awaiting confirmation
        if (!($context->continuity['awaiting_confirmation'] ?? false)) {
            return null;
        }

        // User chose to resume previous session
        if ($input === ($config['resume_option_key'] ?? '1')) {
            $this->events->dispatch(new SessionResumed($context));
            // Restore the state from continuity metadata
            $context->currentState = $context->continuity['state'] ?? $this->config->get('ussd.initial_state');
            $this->sessions->clearContinuity($context);
            // Update continuity for the resumed state
            $this->sessions->touchContinuity($context, $context->currentState);

            return $this->resolveState($context->currentState)->entry($context);
        }

        // User chose to restart from beginning — show initial state
        if ($input === ($config['restart_option_key'] ?? '2')) {
            $this->events->dispatch(new SessionRestarted($context));
            $initialState = $this->config->get('ussd.initial_state');
            $context->currentState = $initialState;
            $context->data = [];
            $this->sessions->clearContinuity($context);
            $this->sessions->touchContinuity($context, $initialState);
            $this->sessions->save($context);

            return $this->resolveState($initialState)->entry($context);
        }

        // Invalid option (e.g. "0") - treat as restart; do not re-show continuity prompt
        $this->events->dispatch(new SessionRestarted($context));
        $context->currentState = $this->config->get('ussd.initial_state');
        $context->data = [];
        $this->sessions->clearContinuity($context);
        $this->sessions->touchContinuity($context, $context->currentState);

        return $this->resolveState($context->currentState)->entry($context);
    }

    /**
     * Resolve a state class from its fully qualified name.
     *
     * Uses Laravel's container to instantiate the state class,
     * allowing dependency injection.
     *
     * @param string $class Fully qualified class name of the state
     * @return State Resolved state instance
     */
    protected function resolveState(string $class): State
    {
        return $this->container->make($class);
    }

    /**
     * Build the resume prompt message text.
     *
     * Constructs a formatted menu with resume and restart options.
     * Optionally includes an error message if user provided invalid input.
     *
     * @param array $config Continuity configuration array
     * @param string|null $error Optional error message to display
     * @return string Formatted menu text
     */
    protected function resumePromptMessage(array $config, ?string $error = null): string
    {
        $lines = [];

        // Add error message if provided
        if ($error) {
            $lines[] = $error;
        }

        // Build the prompt with configurable options
        $lines[] = $config['resume_prompt'] ?? 'Resume previous session?';
        $lines[] = sprintf('%s. %s', $config['resume_option_key'] ?? '1', $config['resume_option_text'] ?? 'Resume previous session');
        $lines[] = sprintf('%s. %s', $config['restart_option_key'] ?? '2', $config['restart_option_text'] ?? 'Start over');

        return implode("\n", $lines);
    }
}
