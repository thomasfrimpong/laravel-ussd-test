<?php

namespace Vendor\LaravelUssd\Support;

/**
 * USSD response value object.
 *
 * Represents a formatted USSD response that will be sent to the gateway.
 * USSD responses must be prefixed with either "CON" (continue) or "END" (end session).
 */
class UssdResponse
{
    /**
     * Create a new USSD response.
     *
     * @param string $type Response type: "CON" or "END"
     * @param string $message Response message body
     */
    public function __construct(
        public readonly string $type,
        public readonly string $message,
    ) {
    }

    /**
     * Create a CONTINUE response.
     *
     * CON indicates the session should continue and wait for more user input.
     *
     * @param string $message Response message to display to user
     * @return self CONTINUE response instance
     */
    public static function continue(string $message): self
    {
        return new self('CON', $message);
    }

    /**
     * Create an END response.
     *
     * END indicates the session is complete and should be terminated.
     *
     * @param string $message Final message to display to user
     * @return self END response instance
     */
    public static function end(string $message): self
    {
        return new self('END', $message);
    }

    /**
     * Convert response to string format expected by USSD gateway.
     *
     * Format: "TYPE MESSAGE"
     *
     * @return string Formatted response string
     */
    public function __toString(): string
    {
        return $this->type . ' ' . $this->message;
    }
}
