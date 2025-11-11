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

        // Create new context if session doesn't exist
        if (!$payload) {
            return new Context(
                sessionId: $sessionId,
                msisdn: $msisdn,
                currentState: $this->config->get('ussd.initial_state'),
                data: [],
                continuity: null
            );
        }

        // Deserialize existing context
        return Context::fromArray($payload);
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

        // Update continuity metadata with current state and timestamp
        $context->continuity = [
            'state' => $state,
            'payload' => $payload,
            'timestamp' => CarbonImmutable::now()->toIso8601String(),
            'awaiting_confirmation' => false,
        ];

        $this->save($context);
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
    }
}
