<?php

namespace Vendor\LaravelUssd\Support;

/**
 * Context value object representing a USSD session.
 *
 * This class holds all session-related data including the current state,
 * user data collected during the session, and continuity metadata for
 * session resume functionality.
 */
class Context
{
    /**
     * Create a new Context instance.
     *
     * @param string $sessionId Unique session identifier from the USSD gateway
     * @param string $msisdn Phone number of the user (Mobile Station International Subscriber Directory Number)
     * @param string $currentState Fully qualified class name of the current state
     * @param array $data Arbitrary data collected during the session (key-value pairs)
     * @param array|null $continuity Continuity metadata for session resume feature
     */
    public function __construct(
        public readonly string $sessionId,
        public readonly string $msisdn,
        public string $currentState,
        public array $data = [],
        public ?array $continuity = null,
    ) {
    }

    /**
     * Create a Context instance from an array payload.
     *
     * Used when deserializing context from cache storage.
     *
     * @param array $payload Array containing session data
     * @return self New Context instance
     */
    public static function fromArray(array $payload): self
    {
        return new self(
            $payload['sessionId'],
            $payload['msisdn'],
            $payload['currentState'],
            $payload['data'] ?? [],
            $payload['continuity'] ?? null,
        );
    }

    /**
     * Convert the context to an array for storage.
     *
     * Used when serializing context to cache storage.
     *
     * @return array Array representation of the context
     */
    public function toArray(): array
    {
        return [
            'sessionId' => $this->sessionId,
            'msisdn' => $this->msisdn,
            'currentState' => $this->currentState,
            'data' => $this->data,
            'continuity' => $this->continuity,
        ];
    }
}
