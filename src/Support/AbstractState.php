<?php

namespace Vendor\LaravelUssd\Support;

use Vendor\LaravelUssd\Contracts\State;
use Vendor\LaravelUssd\Menu\Menu;
use function config;

/**
 * Abstract base class for USSD states.
 *
 * Provides a convenient base implementation that handles menu building
 * and response formatting. Subclasses only need to implement buildMenu()
 * and next() methods.
 */
abstract class AbstractState implements State
{
    /**
     * The current session context.
     *
     * @var Context|null
     */
    protected ?Context $context = null;

    /**
     * Internal storage for Record instance.
     * Made private to ensure __get is always triggered when accessing $this->record.
     *
     * @var Record|null
     */
    private ?Record $recordInstance = null;

    /**
     * Build the menu for this state.
     *
     * Subclasses must implement this method to define the menu structure.
     *
     * @param Context $context Current session context
     * @return Menu Menu instance with content
     */
    abstract protected function buildMenu(Context $context): Menu;

    /**
     * Convert a menu to a USSD response.
     *
     * Automatically determines if response should be CON or END based on
     * whether the menu expects input.
     *
     * @param Menu $menu Menu instance to convert
     * @param bool|null $expectsInput Whether the menu expects user input. If null, uses the menu's current setting.
     * @return UssdResponse Formatted response
     */
    protected function response(Menu $menu, ?bool $expectsInput = null): UssdResponse
    {
        // Only override if explicitly provided, otherwise respect menu's current setting
        if ($expectsInput !== null) {
            $menu->expectsInput($expectsInput);
        } elseif (!$menu->hasExplicitInputExpectation()) {
            // If not explicitly set on menu or in response() call, check if menu has options
            // and default to expecting input for backward compatibility
            // We detect options by checking if the rendered menu contains numbered options (pattern: "X. ")
            $rendered = $menu->render();
            // Check if menu contains numbered options (e.g., "1. Option", "2. Another")
            if (preg_match('/^\d+\.\s+/m', $rendered)) {
                $menu->expectsInput(true);
            }
        }

        // Append configured suffix if provided
        $suffix = config('ussd.default_response_suffix', '');

        return $menu->needsInput()
            ? UssdResponse::continue($menu->render($suffix))
            : UssdResponse::end($menu->render($suffix));
    }

    /**
     * Handle entry into this state.
     *
     * Builds the menu and returns the appropriate response.
     *
     * @param Context $context Current session context
     * @return UssdResponse Response to send to user
     */
    public function entry(Context $context): UssdResponse
    {
        $this->setContext($context);
        return $this->response($this->buildMenu($context));
    }

    /**
     * Set the current context and initialize helpers.
     *
     * @param Context $context Current session context
     * @return void
     */
    protected function setContext(Context $context): void
    {
        $this->context = $context;
        $this->recordInstance = new Record($context);
    }

    /**
     * Get a Decision instance for the given input.
     *
     * Usage in next() method:
     * return $this->decision($input)
     *     ->equal('1', StateClass::class)
     *     ->any(DefaultState::class);
     *
     * @param string $input User input to evaluate
     * @return Decision Decision instance for chaining
     */
    protected function decision(string $input): Decision
    {
        return new Decision($input);
    }

    /**
     * Get the Record instance for storing/retrieving session data.
     *
     * Usage:
     * $this->record->set('key', 'value');
     * $value = $this->record->get('key');
     *
     * @return Record Record instance
     * @throws \RuntimeException If context is not set
     */
    protected function record(): Record
    {
        if ($this->context === null) {
            throw new \RuntimeException('Context must be set before accessing record. Call $this->setContext($context) in your next() or buildMenu() method.');
        }

        if ($this->recordInstance === null) {
            $this->recordInstance = new Record($this->context);
        }

        return $this->recordInstance;
    }

    /**
     * Magic method to access record as a property.
     *
     * Allows usage like $this->record->set() instead of $this->record()->set()
     *
     * Note: Context must be set (via setContext() or entry()) before accessing record.
     * In next() method, call $this->setContext($context) first.
     *
     * @param string $name Property name
     * @return mixed Property value
     * @throws \RuntimeException If context is not set when accessing record
     */
    public function __get(string $name)
    {
        if ($name === 'record') {
            return $this->record();
        }

        return null;
    }

    /**
     * Magic method to check if record property is set.
     *
     * @param string $name Property name
     * @return bool True if property exists and is accessible
     */
    public function __isset(string $name): bool
    {
        if ($name === 'record') {
            return $this->context !== null;
        }

        return false;
    }
}
