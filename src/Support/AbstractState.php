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
     * @param bool $expectsInput Whether the menu expects user input
     * @return UssdResponse Formatted response
     */
    protected function response(Menu $menu, bool $expectsInput = true): UssdResponse
    {
        $menu->expectsInput($expectsInput);

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
        return $this->response($this->buildMenu($context));
    }
}
