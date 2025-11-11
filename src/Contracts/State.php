<?php

namespace Vendor\LaravelUssd\Contracts;

use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;

/**
 * State contract for USSD application states.
 *
 * Each state represents a screen or menu in the USSD flow.
 * States are responsible for rendering menus and determining transitions.
 */
interface State
{
    /**
     * Handle entry into this state.
     *
     * Called when the user first enters this state (no input provided)
     * or when transitioning from another state.
     *
     * @param Context $context Current session context
     * @return UssdResponse Response to send to the user
     */
    public function entry(Context $context): UssdResponse;

    /**
     * Process user input and determine next state.
     *
     * Called when the user provides input while in this state.
     * Return the fully qualified class name of the next state, or null to end the session.
     *
     * @param Context $context Current session context
     * @param string $input User's input
     * @return string|null Fully qualified class name of next state, or null to end session
     */
    public function next(Context $context, string $input): string|null;
}
