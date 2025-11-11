<?php

namespace Vendor\LaravelUssd\Events;

use Vendor\LaravelUssd\Support\Context;

/**
 * Event fired when a user resumes a previous session.
 *
 * Dispatched when the user chooses to resume from a previous incomplete session
 * via the session continuity feature. Listeners can use this for analytics
 * or to restore additional session data.
 */
class SessionResumed
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
