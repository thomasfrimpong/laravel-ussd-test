<?php

namespace Vendor\LaravelUssd\Events;

use Vendor\LaravelUssd\Support\Context;

/**
 * Event fired when a user restarts a session.
 *
 * Dispatched when the user chooses to start over instead of resuming
 * a previous incomplete session. Listeners can use this for analytics
 * or to clear additional session-related data.
 */
class SessionRestarted
{
    /**
     * Create a new event instance.
     *
     * @param Context $context Current session context
     */
    public function __construct(public Context $context)
    {
    }
}
