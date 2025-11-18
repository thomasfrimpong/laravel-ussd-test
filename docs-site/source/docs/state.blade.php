@extends('_layouts.master')

@section('title', 'State')

@push('styles')
@php
    $base = $basePath ?? '/laravel-ussd-test';
    $base = rtrim($base, '/');
@endphp
<link rel="stylesheet" href="{{ $base }}/assets/app.css">
<script src="{{ $base }}/assets/app.js" defer></script>
@endpush

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>State</h1>

    <p class="text-lg text-gray-600 mb-8">States are the core building blocks of your USSD application. Each state represents a screen or step in your USSD flow.</p>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Creating a State</h2>

        <p>Use the Artisan command to create a new state:</p>

        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
            <pre class="text-white text-sm"><code>php artisan ussd:state WelcomeState</code></pre>
        </div>

        <p class="mb-0">This will create a new state class in <code class="bg-gray-100 px-2 py-1 rounded">app/Ussd/States/WelcomeState.php</code>.</p>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">State Structure</h2>

        <p>A typical state class looks like this:</p>

        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
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
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">State Methods</h2>

        <div class="space-y-6">
            <div>
                <h3 class="mb-2">menu()</h3>
                <p class="mb-0">Returns a new Menu instance for building USSD menus.</p>
            </div>

            <div>
                <h3 class="mb-2">next($method)</h3>
                <p class="mb-0">Transitions to the next state or method within the same state.</p>
            </div>

            <div>
                <h3 class="mb-2">end($message)</h3>
                <p class="mb-0">Ends the USSD session with a final message.</p>
            </div>

            <div>
                <h3 class="mb-2">context</h3>
                <p class="mb-0">Access the current context which contains user input, session data, and request information.</p>
            </div>
        </div>
    </section>
</div>
@endsection

