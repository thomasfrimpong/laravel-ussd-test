<?php

namespace Vendor\LaravelUssd\Events;

use Vendor\LaravelUssd\Support\Context;

/**
 * Event fired when a user enters a state.
 *
 * Dispatched by the Machine when transitioning into a new state.
 * Listeners can use this for logging, analytics, or other side effects.
 */
class StateEntered
{
    /**
     * Create a new event instance.
     *
     * @param Context $context Current session context
     * @param string $stateClass Fully qualified class name of the entered state
     */
    public function __construct(
        public Context $context,
        public string $stateClass
    ) {
    }
}
