<?php

namespace Vendor\LaravelUssd\Support;

/**
 * USSD response value object.
 *
 * Represents a formatted USSD response that will be sent to the gateway.
 * USSD responses must be prefixed with either "CON" (continue) or "END" (end session).
 */
class UssdResponse implements \JsonSerializable
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
    ) {}

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

    /**
     * Convert response to array format for JSON responses.
     *
     * Returns array with ussdServiceOp and message fields.
     * ussdServiceOp is set to "2" for CON (continue) responses and "17" for END (terminal) responses.
     *
     * @return array Array representation with ussdServiceOp and message
     */
    public function toArray(): array
    {
        return [
            'ussdServiceOp' => $this->type === 'END' ? '17' : '2',
            'message' => $this->message,
        ];
    }

    /**
     * Convert response to JSON format.
     *
     * @return string JSON representation of the response
     */
    public function toJson(): string
    {
        return json_encode($this->toArray());
    }

    /**
     * Specify data which should be serialized to JSON.
     *
     * This ensures Laravel's JSON serialization uses our custom format.
     *
     * @return array Data which can be serialized by json_encode()
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
