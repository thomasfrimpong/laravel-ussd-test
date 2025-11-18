@extends('_layouts.master')

@section('title', 'Menu')

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
    <h1>Menu</h1>

    <p class="text-lg text-gray-600 mb-8">The Menu class provides a fluent interface for building USSD menus and responses.</p>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Basic Usage</h2>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
            <pre class="text-white text-sm"><code>return $this->menu()
    ->text('Welcome!')
    ->options([
        '1' => 'Option 1',
        '2' => 'Option 2',
    ])
    ->expectsInput()
    ->next('handleOption');</code></pre>
        </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Menu Methods</h2>
        <div class="space-y-6">
            <div>
                <h3 class="mb-2">text($text)</h3>
                <p class="mb-0">Sets the main text content of the menu.</p>
            </div>

            <div>
                <h3 class="mb-2">options(array $options)</h3>
                <p class="mb-0">Sets the menu options. The array key is the option number, and the value is the option text.</p>
            </div>

            <div>
                <h3 class="mb-2">expectsInput()</h3>
                <p class="mb-0">Indicates that the menu expects user input (CON response).</p>
            </div>

            <div>
                <h3 class="mb-2">noInput()</h3>
                <p class="mb-0">Indicates that the menu does not expect input (END response).</p>
            </div>

            <div>
                <h3 class="mb-2">next($stateOrMethod)</h3>
                <p class="mb-0">Sets the next state or method to transition to after this menu.</p>
            </div>
        </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Example</h2>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
            <pre class="text-white text-sm"><code>return $this->menu()
    ->text('Select an option:')
    ->options([
        '1' => 'Check Balance',
        '2' => 'Transfer Funds',
        '3' => 'View History',
    ])
    ->expectsInput()
    ->next('processSelection');</code></pre>
        </div>
    </section>
</div>
@endsection

