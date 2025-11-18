@extends('_layouts.master')

@section('title', 'Installation')

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>Installation</h1>

    <p>You can install the package via composer:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>composer require catalysteria/laravel-ussd</code></pre>
    </div>

    <h2>Publish Configuration</h2>

    <p>Laravel USSD provides zero configuration out of the box. To publish the config, run the vendor publish command:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>php artisan vendor:publish --provider="Vendor\LaravelUssd\Providers\LaravelUssdServiceProvider"</code></pre>
    </div>

    <p>This will publish the configuration file to <code class="bg-gray-100 px-2 py-1 rounded">config/ussd.php</code>.</p>

    <h2>Configuration File</h2>

    <p>This is the default content of the config file:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>return [
    'initial_state' => 'App\\Ussd\\States\\WelcomeState',

    'state_namespace' => 'App\\Ussd\\States',

    'action_namespace' => 'App\\Ussd\\Actions',

    'cache_store' => env('USSD_CACHE_STORE', null),

    'default_response_suffix' => '',

    'error_state' => null,

    'max_retries' => 3,

    'continuity' => [
        'enabled' => true,
        'timeout' => 900,
        'resume_prompt' => 'We noticed you have an unfinished session. Choose an option:',
        'resume_option_key' => '1',
        'resume_option_text' => 'Resume previous session',
        'restart_option_key' => '2',
        'restart_option_text' => 'Start over',
    ],
];</code></pre>
    </div>

    <h2>Understanding the Configuration</h2>

    <p>By default, new state classes will be created in <code class="bg-gray-100 px-2 py-1 rounded">app/Ussd/States</code> directory with <code class="bg-gray-100 px-2 py-1 rounded">App\Ussd\States</code> namespace. That can be changed with the <code class="bg-gray-100 px-2 py-1 rounded">state_namespace</code> variable in <code class="bg-gray-100 px-2 py-1 rounded">config/ussd.php</code>.</p>

    <p>Also, a new action with <code class="bg-gray-100 px-2 py-1 rounded">App\Ussd\Actions</code> namespace by default. You can change it just like the states.</p>

    <p>The <code class="bg-gray-100 px-2 py-1 rounded">cache_store</code> variable specifies which particular store to use. The list can be found in <code class="bg-gray-100 px-2 py-1 rounded">config/cache.php</code> under the <code class="bg-gray-100 px-2 py-1 rounded">stores</code> array variable. Leave it at null to use your default cache-store.</p>

    <h2>Register the USSD Route</h2>

    <p>Register the USSD route in <code class="bg-gray-100 px-2 py-1 rounded">routes/api.php</code>:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>Route::post('/ussd', \Vendor\LaravelUssd\Http\Controllers\UssdController::class)
    ->middleware('ussd.normalize');</code></pre>
    </div>

    <h2>Create Your First State</h2>

    <p>Scaffold your first state:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>php artisan ussd:state WelcomeState</code></pre>
    </div>
</div>
@endsection

