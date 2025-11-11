<?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

class WelcomeState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Welcome to Laravel USSD')
            ->option('1', 'View balance')
            ->option('2', 'Transfer funds');
    }

    public function next(Context $context, string $input): ?string
    {
        return match ($input) {
            '1' => 'App\\Ussd\\States\\BalanceState',
            '2' => 'App\\Ussd\\States\\TransferState',
            default => null,
        };
    }
}
