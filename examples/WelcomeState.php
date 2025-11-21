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
        // IMPORTANT: Must return a State class name (string) or null
        // Never return an Action class name - actions are called, not returned
        return match ($input) {
            '1' => 'App\\Ussd\\States\\BalanceState',  // ✅ State class name
            '2' => 'App\\Ussd\\States\\TransferState',  // ✅ State class name
            default => null,  // End session
        };
    }
}
