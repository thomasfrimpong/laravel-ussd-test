@extends('_layouts.master')

@section('title', 'Testing')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Testing
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">This guide explains how to test the Laravel USSD package.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Running Tests
        </h2>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Run All Tests</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">composer test
# or
vendor/bin/phpunit</code></pre>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Run Specific Test Suites</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100"># Run only unit tests
vendor/bin/phpunit tests/Unit

# Run only feature tests
vendor/bin/phpunit tests/Feature

# Run a specific test file
vendor/bin/phpunit tests/Feature/UssdFlowTest.php</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Test Structure
        </h2>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Unit Tests</h3>
            <p class="text-slate-700 mb-3">Test individual components in isolation:</p>
            <ul class="space-y-2 text-slate-700 mb-0">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">MenuTest.php</code> - Menu builder functionality
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">UssdResponseTest.php</code> - Response formatting
                </li>
            </ul>
        </div>

        <div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">Feature Tests</h3>
            <p class="text-slate-700 mb-3">Test complete flows and integrations:</p>
            <ul class="space-y-2 text-slate-700 mb-0">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">UssdFlowTest.php</code> - Basic USSD flow testing
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">SessionContinuityTest.php</code> - Session resume functionality
                </li>
            </ul>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Testing in a Real Laravel Application
        </h2>
        <p class="text-slate-700 mb-4">To test the package in a real Laravel application, you can add it as a local path repository in your test app's <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">composer.json</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">{
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
        <p class="text-slate-700 mb-4">Then install and test:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">composer update catalysteria/laravel-ussd
php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
php artisan ussd:state WelcomeState</code></pre>
        </div>
    </section>
</div>
@endsection
