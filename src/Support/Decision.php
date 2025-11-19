<?php

namespace Vendor\LaravelUssd\Support;

/**
 * Fluent decision builder for routing based on user input.
 *
 * Provides a chainable API for creating decision trees that determine
 * which state to transition to based on user input validation.
 */
class Decision
{
    /**
     * The user input being evaluated.
     *
     * @var string
     */
    protected string $input;

    /**
     * Create a new Decision instance.
     *
     * @param string $input The user input to evaluate
     */
    public function __construct(string $input)
    {
        $this->input = $input;
    }

    /**
     * Check if input exactly matches the given value.
     *
     * @param string $value Value to match against
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function equal(string $value, ?string $state)
    {
        if ($this->input === $value) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if input is numeric.
     *
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function numeric(?string $state)
    {
        if (is_numeric($this->input)) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if input is a valid integer.
     *
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function integer(?string $state)
    {
        if (is_numeric($this->input) && (int) $this->input == $this->input) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if input is a valid monetary amount.
     *
     * Validates that the input is a positive numeric value.
     *
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function amount(?string $state)
    {
        if (is_numeric($this->input) && (float) $this->input > 0) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if input length is between min and max (inclusive).
     *
     * @param int $min Minimum length
     * @param int $max Maximum length
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function length(int $min, int $max, ?string $state)
    {
        $length = strlen($this->input);
        if ($length >= $min && $length <= $max) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if input is a valid phone number format.
     *
     * Validates that the input contains only digits and optional leading +.
     *
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function phoneNumber(?string $state)
    {
        // Remove + if present and check if remaining is numeric
        $cleaned = ltrim($this->input, '+');
        if (ctype_digit($cleaned) && strlen($cleaned) >= 9 && strlen($cleaned) <= 15) {
            return $state;
        }

        return $this;
    }

    /**
     * Check if numeric input is between min and max (inclusive).
     *
     * @param int|float $min Minimum value
     * @param int|float $max Maximum value
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function between($min, $max, ?string $state)
    {
        if (is_numeric($this->input)) {
            $value = (float) $this->input;
            if ($value >= $min && $value <= $max) {
                return $state;
            }
        }

        return $this;
    }

    /**
     * Check if input is one of the provided values.
     *
     * @param array $values Array of values to check against
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function in(array $values, ?string $state)
    {
        if (in_array($this->input, $values, true)) {
            return $state;
        }

        return $this;
    }

    /**
     * Check input using a custom callback function.
     *
     * @param callable $callback Callback that receives input and returns bool
     * @param string|null $state Next state class name, or null to end session
     * @return mixed Next state (string|null) if matched, or self for chaining
     */
    public function custom(callable $callback, ?string $state)
    {
        if ($callback($this->input)) {
            return $state;
        }

        return $this;
    }

    /**
     * Catch-all that matches any input.
     *
     * Should be used as the last method in the chain as a fallback.
     *
     * @param string|null $state Next state class name, or null to end session
     * @return string|null Next state or null
     */
    public function any(?string $state): ?string
    {
        return $state;
    }
}

