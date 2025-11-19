<?php

namespace Vendor\LaravelUssd\Support;

/**
 * Record manager for storing and retrieving session data.
 *
 * Provides a convenient interface for accessing the Context's data array,
 * allowing states to store and retrieve values throughout a USSD session.
 */
class Record
{
    /**
     * The context instance containing the session data.
     *
     * @var Context
     */
    protected Context $context;

    /**
     * Create a new Record instance.
     *
     * @param Context $context The session context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * Store a single value with the specified key.
     *
     * @param string $key The key to store the value under
     * @param mixed $value The value to store
     * @return self For method chaining
     */
    public function set(string $key, $value): self
    {
        $this->context->data[$key] = $value;

        return $this;
    }

    /**
     * Store multiple key-value pairs at once.
     *
     * @param array $data Associative array of key-value pairs
     * @return self For method chaining
     */
    public function setMultiple(array $data): self
    {
        foreach ($data as $key => $value) {
            $this->context->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Retrieve a stored value by key.
     *
     * @param string $key The key to retrieve
     * @param mixed $default Default value if key doesn't exist
     * @return mixed The stored value or default
     */
    public function get(string $key, $default = null)
    {
        return $this->context->data[$key] ?? $default;
    }

    /**
     * Retrieve multiple values at once.
     *
     * @param array $keys Array of keys to retrieve
     * @return array Associative array of key-value pairs
     */
    public function getMultiple(array $keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->context->data[$key] ?? null;
        }

        return $result;
    }

    /**
     * Check if a key exists in the stored data.
     *
     * @param string $key The key to check
     * @return bool True if key exists, false otherwise
     */
    public function has(string $key): bool
    {
        return isset($this->context->data[$key]);
    }

    /**
     * Remove a stored value by key.
     *
     * @param string $key The key to remove
     * @return self For method chaining
     */
    public function delete(string $key): self
    {
        unset($this->context->data[$key]);

        return $this;
    }
}

