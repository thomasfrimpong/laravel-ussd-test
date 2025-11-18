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

    <p>The Menu class provides a fluent interface for building USSD menus and responses.</p>

    <h2>Basic Usage</h2>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>return $this->menu()
    ->text('Welcome!')
    ->options([
        '1' => 'Option 1',
        '2' => 'Option 2',
    ])
    ->expectsInput()
    ->next('handleOption');</code></pre>
    </div>

    <h2>Menu Methods</h2>

    <h3>text($text)</h3>
    <p>Sets the main text content of the menu.</p>

    <h3>options(array $options)</h3>
    <p>Sets the menu options. The array key is the option number, and the value is the option text.</p>

    <h3>expectsInput()</h3>
    <p>Indicates that the menu expects user input (CON response).</p>

    <h3>noInput()</h3>
    <p>Indicates that the menu does not expect input (END response).</p>

    <h3>next($stateOrMethod)</h3>
    <p>Sets the next state or method to transition to after this menu.</p>

    <h2>Example</h2>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
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
</div>
@endsection

