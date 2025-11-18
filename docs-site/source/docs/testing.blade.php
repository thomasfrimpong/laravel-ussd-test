@extends('_layouts.master')

@section('title', 'Testing')

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
    <h1>Testing</h1>

    <p class="text-lg text-gray-600 mb-8">This guide explains how to test the Laravel USSD package.</p>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Running Tests</h2>
        
        <div class="mb-6">
            <h3 class="mb-3">Run All Tests</h3>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
                <pre class="text-white text-sm"><code>composer test
# or
vendor/bin/phpunit</code></pre>
            </div>
        </div>

        <div>
            <h3 class="mb-3">Run Specific Test Suites</h3>
            <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
                <pre class="text-white text-sm"><code># Run only unit tests
vendor/bin/phpunit tests/Unit

# Run only feature tests
vendor/bin/phpunit tests/Feature

# Run a specific test file
vendor/bin/phpunit tests/Feature/UssdFlowTest.php</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Test Structure</h2>
        
        <div class="mb-6">
            <h3 class="mb-3">Unit Tests</h3>
            <p class="mb-3">Test individual components in isolation:</p>
            <ul class="mb-0">
                <li><code class="bg-gray-100 px-2 py-1 rounded">MenuTest.php</code> - Menu builder functionality</li>
                <li><code class="bg-gray-100 px-2 py-1 rounded">UssdResponseTest.php</code> - Response formatting</li>
            </ul>
        </div>

        <div>
            <h3 class="mb-3">Feature Tests</h3>
            <p class="mb-3">Test complete flows and integrations:</p>
            <ul class="mb-0">
                <li><code class="bg-gray-100 px-2 py-1 rounded">UssdFlowTest.php</code> - Basic USSD flow testing</li>
                <li><code class="bg-gray-100 px-2 py-1 rounded">SessionContinuityTest.php</code> - Session resume functionality</li>
            </ul>
        </div>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Testing in a Real Laravel Application</h2>
        <p>To test the package in a real Laravel application, you can add it as a local path repository in your test app's <code class="bg-gray-100 px-2 py-1 rounded">composer.json</code>:</p>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
            <pre class="text-white text-sm"><code>{
  "repositories": [
    {
      "type": "path",
      "url": "../laravel-ussd"
    }
  ],
  "require": {
    "catalysteria/laravel-ussd": "@dev"
  }
}</code></pre>
        </div>
        <p class="mb-0">Then install and test:</p>
        <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto my-4">
            <pre class="text-white text-sm"><code>composer update catalysteria/laravel-ussd
php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
php artisan ussd:state WelcomeState</code></pre>
        </div>
    </section>
</div>
@endsection

