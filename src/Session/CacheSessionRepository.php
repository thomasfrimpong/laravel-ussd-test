<?php

namespace Vendor\LaravelUssd\Session;

use Carbon\CarbonImmutable;
use Illuminate\Cache\Repository as CacheRepository;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Vendor\LaravelUssd\Support\Context;

/**
 * Cache-based session repository implementation.
 *
 * Stores session data in Laravel's cache system with configurable TTL.
 * Uses a composite key based on MSISDN and session ID for uniqueness.
 */
class CacheSessionRepository implements SessionRepositoryInterface
{
    /**
     * Create a new cache session repository.
     *
     * @param CacheRepository $cache Laravel cache repository
     * @param ConfigRepository $config Configuration repository
     */
    public function __construct(
        protected CacheRepository $cache,
        protected ConfigRepository $config
    ) {
    }

    /**
     * Generate cache key for a session.
     *
     * Format: "ussd:{msisdn}:{sessionId}"
     *
     * @param string $sessionId Session identifier
     * @param string $msisdn Phone number
     * @return string Cache key
     */
    protected function key(string $sessionId, string $msisdn): string
    {
        return sprintf('ussd:%s:%s', $msisdn, $sessionId);
    }

    /**
     * Generate the MSISDN-level continuity key.
     *
     * This key is independent of the session ID so that a brand-new dial-in
     * (which the gateway assigns a fresh session ID after a cancel, timeout, or
     * crash) can still locate the user's last progress for resume.
     *
     * Format: "ussd:continuity:{msisdn}"
     *
     * @param string $msisdn Phone number
     * @return string Continuity cache key
     */
    protected function continuityKey(string $msisdn): string
    {
        return sprintf('ussd:continuity:%s', $msisdn);
    }

    /**
     * Load the MSISDN-level continuity snapshot, if any.
     *
     * @param string $msisdn Phone number
     * @return array|null Snapshot data or null when none exists
     */
    protected function loadContinuitySnapshot(string $msisdn): ?array
    {
        $snapshot = $this->cache->get($this->continuityKey($msisdn));

        return is_array($snapshot) ? $snapshot : null;
    }

    /**
     * Load session context from cache.
     *
     * If no session exists, creates a new context with the configured initial state.
     *
     * @param string $sessionId Session identifier
     * @param string $msisdn Phone number
     * @return Context Session context
     */
    public function load(string $sessionId, string $msisdn): Context
    {
        $payload = $this->cache->get($this->key($sessionId, $msisdn));

        // Deserialize existing in-session context when present
        if ($payload) {
            return Context::fromArray($payload);
        }

        // No per-session record exists. This happens on a brand-new dial-in,
        // including when a previous session was abandoned (cancel/timeout/crash)
        // and the gateway issued a fresh session ID. Fall back to the
        // MSISDN-level continuity snapshot so the previous progress can be
        // offered for resume.
        $snapshot = $this->config->get('ussd.continuity.enabled', false)
            ? $this->loadContinuitySnapshot($msisdn)
            : null;

        if ($snapshot !== null) {
            return new Context(
                sessionId: $sessionId,
                msisdn: $msisdn,
                currentState: $this->config->get('ussd.initial_state'),
                data: $snapshot['data'] ?? [],
                continuity: [
                    'state' => $snapshot['state'] ?? $this->config->get('ussd.initial_state'),
                    'payload' => $snapshot['payload'] ?? [],
                    'timestamp' => $snapshot['timestamp'] ?? null,
                    'awaiting_confirmation' => false,
                ],
            );
        }

        // Create a brand-new context with the configured initial state
        return new Context(
            sessionId: $sessionId,
            msisdn: $msisdn,
            currentState: $this->config->get('ussd.initial_state'),
            data: [],
            continuity: null
        );
    }

    /**
     * Save session context to cache.
     *
     * Uses continuity timeout as TTL to ensure sessions expire appropriately.
     *
     * @param Context $context Session context to save
     * @return void
     */
    public function save(Context $context): void
    {
        // Use continuity timeout as TTL (default: 15 minutes)
        $ttl = $this->config->get('ussd.continuity.timeout', 900);

        $this->cache->put(
            $this->key($context->sessionId, $context->msisdn),
            $context->toArray(),
            $ttl
        );
    }

    /**
     * Clear session from cache.
     *
     * @param string $sessionId Session identifier
     * @param string $msisdn Phone number
     * @return void
     */
    public function clear(string $sessionId, string $msisdn): void
    {
        $this->cache->forget($this->key($sessionId, $msisdn));

        // A normally-completed session must never be offered for resume, so
        // drop the MSISDN-level continuity snapshot as well.
        $this->cache->forget($this->continuityKey($msisdn));
    }

    /**
     * Update continuity metadata for session resume.
     *
     * Only updates if continuity is enabled in configuration.
     *
     * @param Context $context Session context
     * @param string $state Current state class name
     * @param array $payload Optional additional data
     * @return void
     */
    public function touchContinuity(Context $context, string $state, array $payload = []): void
    {
        // Skip if continuity is disabled
        if (!$this->config->get('ussd.continuity.enabled', false)) {
            return;
        }

        $timestamp = CarbonImmutable::now()->toIso8601String();

        // Update continuity metadata with current state and timestamp
        $context->continuity = [
            'state' => $state,
            'payload' => $payload,
            'timestamp' => $timestamp,
            'awaiting_confirmation' => false,
        ];

        $this->save($context);

        // Persist an MSISDN-level snapshot (independent of session ID) so a
        // later dial-in after cancel/timeout/crash can resume this progress.
        $ttl = $this->config->get('ussd.continuity.timeout', 900);

        $this->cache->put($this->continuityKey($context->msisdn), [
            'state' => $state,
            'payload' => $payload,
            'data' => $context->data,
            'timestamp' => $timestamp,
        ], $ttl);
    }

    /**
     * Clear continuity metadata.
     *
     * @param Context $context Session context
     * @return void
     */
    public function clearContinuity(Context $context): void
    {
        $context->continuity = null;
        $this->save($context);

        // Drop the MSISDN-level snapshot so the session is no longer resumable.
        $this->cache->forget($this->continuityKey($context->msisdn));
    }
}
