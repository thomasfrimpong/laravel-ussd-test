@extends('_layouts.master')

@section('title', 'Installation')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Installation
        </h1>
    </div>

    <section class=" bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Install via Composer
        </h2>
        <p class="text-slate-700 mb-4">You can install the package via composer:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">composer require catalysteria/laravel-ussd</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Publish Configuration
        </h2>
        <p class="text-slate-700 mb-4">Laravel USSD provides zero configuration out of the box. To publish the config, run the vendor publish command:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">php artisan vendor:publish --provider="Vendor\LaravelUssd\Providers\LaravelUssdServiceProvider"</code></pre>
        </div>
        <p class="text-slate-700 mb-0">This will publish the configuration file to <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Configuration File
        </h2>
        <p class="text-slate-700 mb-4">This is the default content of the config file:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed">
                <code class="text-slate-100">
                    return [
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
];
</code>
</pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Understanding the Configuration
        </h2>
        <div class="space-y-4 text-slate-700">
            <p>By default, new state classes will be created in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">app/Ussd/States</code> directory with <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">App\Ussd\States</code> namespace. That can be changed with the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">state_namespace</code> variable in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>.</p>

            <p>Also, a new action with <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">App\Ussd\Actions</code> namespace by default. You can change it just like the states.</p>

            <p class="mb-0">The <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">cache_store</code> variable specifies which particular store to use. The list can be found in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/cache.php</code> under the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">stores</code> array variable. Leave it at null to use your default cache-store.</p>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Register the USSD Route
        </h2>
        <p class="text-slate-700 mb-4">Register the USSD route in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">routes/api.php</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">Route::post('/ussd', \Vendor\LaravelUssd\Http\Controllers\UssdController::class)
    ->middleware('ussd.normalize');</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Create Your First State
        </h2>
        <p class="text-slate-700 mb-4">Scaffold your first state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">php artisan ussd:state WelcomeState</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Set the Initial State
        </h2>
        <p class="text-slate-700 mb-4">The initial state is the first state that users see when they dial your USSD code. Configure it in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">return [
    'initial_state' => 'App\\Ussd\\States\\WelcomeState',
    
    // ... other configuration
];</code></pre>
        </div>
        <p class="text-slate-700 mb-0">Make sure the class name matches the state you created. The initial state must be a fully qualified class name (including namespace). This is the entry point for all new USSD sessions.</p>
    </section>
</div>
@endsection

