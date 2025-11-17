@extends('_layouts.master')

@section('title', 'State')

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>State</h1>

    <p>States are the core building blocks of your USSD application. Each state represents a screen or step in your USSD flow.</p>

    <h2>Creating a State</h2>

    <p>Use the Artisan command to create a new state:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>php artisan ussd:state WelcomeState</code></pre>
    </div>

    <p>This will create a new state class in <code class="bg-gray-100 px-2 py-1 rounded">app/Ussd/States/WelcomeState.php</code>.</p>

    <h2>State Structure</h2>

    <p>A typical state class looks like this:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Menu\Menu;

class WelcomeState extends AbstractState
{
    public function handle()
    {
        return $this->menu()
            ->text('Welcome to our service!')
            ->options([
                '1' => 'View Balance',
                '2' => 'Transfer Money',
                '3' => 'Exit',
            ])
            ->expectsInput()
            ->next('handleOption');
    }

    public function handleOption()
    {
        $input = $this->context->input;

        return match($input) {
            '1' => $this->next('BalanceState'),
            '2' => $this->next('TransferState'),
            '3' => $this->end('Thank you for using our service!'),
            default => $this->menu()
                ->text('Invalid option. Please try again.')
                ->next('handle'),
        };
    }
}</code></pre>
    </div>

    <h2>State Methods</h2>

    <h3>menu()</h3>
    <p>Returns a new Menu instance for building USSD menus.</p>

    <h3>next($method)</h3>
    <p>Transitions to the next state or method within the same state.</p>

    <h3>end($message)</h3>
    <p>Ends the USSD session with a final message.</p>

    <h3>context</h3>
    <p>Access the current context which contains user input, session data, and request information.</p>
</div>
@endsection

