<?php

namespace Vendor\LaravelUssd\Contracts;

use Vendor\LaravelUssd\Support\Context;

/**
 * Action contract for business logic operations.
 *
 * Actions encapsulate side-effects and business logic that should be
 * separated from state presentation logic. Actions can be invoked from
 * states to perform operations like API calls, database updates, etc.
 */
interface Action
{
    /**
     * Execute the action with the given context and input.
     *
     * @param Context $context Current session context
     * @param string $input User's input that triggered this action
     * @return mixed Action result (can be used by states to determine next step)
     */
    public function handle(Context $context, string $input): mixed;
}
