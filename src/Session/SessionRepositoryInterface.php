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
     * Returns the existing per-session context if found. Otherwise, on a fresh
     * dial-in (including after a cancel/timeout/crash where the gateway issued a
     * new session ID), implementations should fall back to any MSISDN-level
     * continuity snapshot and attach it to a new context so the previous
     * progress can be offered for resume. When neither exists, a new context
     * with the configured initial state is returned.
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
     * Implementations should also drop the MSISDN-level continuity snapshot so
     * that a normally-completed session is never offered for resume.
     *
     * @param string $sessionId Unique session identifier
     * @param string $msisdn Phone number of the user
     * @return void
     */
    public function clear(string $sessionId, string $msisdn): void;

    /**
     * Update continuity metadata for session resume feature.
     *
     * Stores the current state and timestamp so the session can be resumed
     * later. Implementations should additionally persist an MSISDN-level
     * snapshot (state plus collected data, keyed independently of the session
     * ID) so a later dial-in with a new session ID can resume this progress.
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
     * Removes continuity data when the session is completed or restarted,
     * including the MSISDN-level snapshot used for cross-session resume.
     *
     * @param Context $context Session context
     * @return void
     */
    public function clearContinuity(Context $context): void;
}
