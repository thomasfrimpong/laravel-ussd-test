<?php

namespace Vendor\LaravelUssd\Tests\Fixtures;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

class WelcomeState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Welcome test menu')
            ->option('1', 'Go next');
    }

    public function next(Context $context, string $input): ?string
    {
        return null;
    }
}
