<?php

namespace Vendor\LaravelUssd\Tests\Fixtures;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

/**
 * First step of a multi-step fixture flow used by continuity tests.
 *
 * Collects the user's name and advances to {@see AgeState}.
 */
class NameState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Enter your name')
            ->expectsInput(true);
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        $this->record->set('name', $input);

        return AgeState::class;
    }
}
