<?php

namespace Vendor\LaravelUssd\Support;

use Vendor\LaravelUssd\Contracts\Action;

/**
 * Abstract base class for USSD actions.
 *
 * Provides a convenient base implementation that makes actions invokable.
 * Subclasses only need to implement the handle() method.
 */
abstract class AbstractAction implements Action
{
    /**
     * Make the action invokable.
     *
     * Allows actions to be called as callables: $action($context, $input)
     *
     * @param Context $context Current session context
     * @param string $input User's input
     * @return mixed Action result
     */
    public function __invoke(Context $context, string $input): mixed
    {
        return $this->handle($context, $input);
    }
}
