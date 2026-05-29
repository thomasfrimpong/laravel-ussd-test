<?php

namespace Vendor\LaravelUssd\Tests\Fixtures;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

/**
 * Second step of a multi-step fixture flow used by continuity tests.
 *
 * Collects the user's age and ends the session.
 */
class AgeState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Enter your age')
            ->expectsInput(true);
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        $this->record->set('age', $input);

        return null;
    }
}
