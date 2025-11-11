<?php

namespace Vendor\LaravelUssd\Events;

use Vendor\LaravelUssd\Support\Context;

/**
 * Event fired when a user exits a state.
 *
 * Dispatched by the Machine when transitioning out of a state.
 * Listeners can use this for logging, analytics, or cleanup operations.
 */
class StateExited
{
    /**
     * Create a new event instance.
     *
     * @param Context $context Current session context
     * @param string $stateClass Fully qualified class name of the exited state
     */
    public function __construct(
        public Context $context,
        public string $stateClass
    ) {
    }
}
