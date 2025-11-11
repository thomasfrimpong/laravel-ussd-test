<?php

namespace Vendor\LaravelUssd\Session;

use Vendor\LaravelUssd\Support\Context;

/**
 * Session repository contract for persisting USSD session data.
 *
 * Implementations should store session context data (state, user data, continuity)
 * and provide methods to load, save, and clear sessions.
 */
interface SessionRepositoryInterface
{
    /**
     * Load session context from storage.
     *
     * Returns existing context if found, or creates a new context with initial state.
     *
     * @param string $sessionId Unique session identifier
     * @param string $msisdn Phone number of the user
     * @return Context Session context
     */
    public function load(string $sessionId, string $msisdn): Context;

    /**
     * Save session context to storage.
     *
     * @param Context $context Session context to persist
     * @return void
     */
    public function save(Context $context): void;

    /**
     * Clear session data from storage.
     *
     * @param string $sessionId Unique session identifier
     * @param string $msisdn Phone number of the user
     * @return void
     */
    public function clear(string $sessionId, string $msisdn): void;

    /**
     * Update continuity metadata for session resume feature.
     *
     * Stores the current state and timestamp so the session can be resumed later.
     *
     * @param Context $context Session context
     * @param string $state Fully qualified class name of the current state
     * @param array $payload Optional additional data to store with continuity
     * @return void
     */
    public function touchContinuity(Context $context, string $state, array $payload = []): void;

    /**
     * Clear continuity metadata.
     *
     * Removes continuity data when session is completed or restarted.
     *
     * @param Context $context Session context
     * @return void
     */
    public function clearContinuity(Context $context): void;
}
