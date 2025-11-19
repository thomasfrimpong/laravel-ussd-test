@extends('_layouts.master')

@section('title', 'Machine')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Machine
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">The Machine class is the central orchestrator that manages the entire USSD application flow. It handles state resolution, user input processing, session continuity, and state transitions throughout the session lifecycle.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Understanding the Machine
        </h2>
        <p class="text-slate-700">The Machine class acts as the application runner, managing the flow of the USSD application. It interprets user requests, navigates between states, and handles session management. The Machine ensures seamless interaction between the user and the application by coordinating all the moving parts.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            How the Machine Works
        </h2>
        <p class="text-slate-700 mb-4">The Machine orchestrates the entire USSD session flow through the following process:</p>
        <ol class="space-y-3 text-slate-700 list-decimal list-inside">
            <li><strong class="text-slate-900">Load Session:</strong> Loads existing session context or creates a new one</li>
            <li><strong class="text-slate-900">Check Continuity:</strong> Determines if session resume should be offered</li>
            <li><strong class="text-slate-900">Resolve State:</strong> Instantiates the current state class using Laravel's container</li>
            <li><strong class="text-slate-900">Process Input:</strong> Handles user input and determines the next state</li>
            <li><strong class="text-slate-900">Transition:</strong> Moves to the next state or ends the session</li>
        </ol>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            The handle() Method
        </h2>
        <p class="text-slate-700 mb-4">The primary method of the Machine class is <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">handle()</code>, which processes incoming USSD requests:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function handle(array $payload): UssdResponse
{
    // Payload contains:
    // - sessionId: Unique session identifier
    // - msisdn: Phone number of the user
    // - input: User's input (empty string for initial request)
    
    // Load or create session context
    $context = $this->sessions->load($payload['sessionId'], $payload['msisdn']);
    
    // Check for session resume
    if ($this->shouldOfferResume($context) && empty($payload['input'])) {
        return $this->makeResumePrompt($context);
    }
    
    // Resolve and process current state
    $state = $this->resolveState($context->currentState);
    
    // Handle state entry or input processing
    // ...
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Session Lifecycle Management
        </h2>
        <p class="text-slate-700 mb-6">The Machine manages the complete session lifecycle:</p>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Session Initialization</h3>
                <p class="text-slate-700 mb-0">When a new session starts, the Machine creates a new context with the configured initial state from <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-800 font-mono text-xs">config/ussd.php</code>.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">State Transitions</h3>
                <p class="text-slate-700 mb-0">The Machine handles transitions between states by calling the <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-800 font-mono text-xs">next()</code> method on the current state, which returns the next state class name.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Session Persistence</h3>
                <p class="text-slate-700 mb-0">After each state transition, the Machine saves the session context to storage, ensuring data persistence across requests.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">Session Termination</h3>
                <p class="text-slate-700 mb-0">When a state returns <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-800 font-mono text-xs">null</code> as the next state, the Machine clears the session data and ends the USSD session.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Session Continuity
        </h2>
        <p class="text-slate-700 mb-4">The Machine supports session continuity, allowing users to resume interrupted sessions:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">// Machine checks if session resume should be offered
if ($this->shouldOfferResume($context) && empty($payload['input'])) {
    return $this->makeResumePrompt($context);
}

// User can choose to:
// 1. Resume previous session (continues from last state)
// 2. Start over (begins from initial state)</code></pre>
        </div>
        <p class="text-slate-700 mb-0">Session continuity is controlled by the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">continuity</code> configuration in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            State Resolution
        </h2>
        <p class="text-slate-700 mb-4">The Machine uses Laravel's service container to resolve state classes, which means:</p>
        <ul class="space-y-2 text-slate-700 mb-4">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                States can use dependency injection
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                States are automatically instantiated with their dependencies
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                You can bind custom implementations in service providers
            </li>
        </ul>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">protected function resolveState(string $class): State
{
    return $this->container->make($class);
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Events
        </h2>
        <p class="text-slate-700 mb-6">The Machine dispatches events throughout the session lifecycle, allowing you to hook into the flow:</p>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">StateEntered</h3>
                <p class="text-slate-700 mb-0">Dispatched when a user enters a state. Provides access to the context and state class name.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">StateExited</h3>
                <p class="text-slate-700 mb-0">Dispatched when a user exits a state (after processing input).</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">SessionResumed</h3>
                <p class="text-slate-700 mb-0">Dispatched when a user chooses to resume a previous session.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">SessionRestarted</h3>
                <p class="text-slate-700 mb-0">Dispatched when a user chooses to start over from the beginning.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Usage in Controllers
        </h2>
        <p class="text-slate-700 mb-4">The Machine is typically used in the USSD controller to handle incoming requests:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace Vendor\LaravelUssd\Http\Controllers;

use Illuminate\Http\Request;
use Vendor\LaravelUssd\Machine\Machine;

class UssdController
{
    public function __construct(protected Machine $machine)
    {
    }

    public function __invoke(Request $request)
    {
        $payload = [
            'sessionId' => $request->input('sessionId'),
            'msisdn' => $request->input('msisdn'),
            'input' => $request->input('text', ''),
        ];

        $response = $this->machine->handle($payload);

        return response()->json($response->toArray());
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Configuration
        </h2>
        <p class="text-slate-700 mb-4">The Machine uses several configuration values from <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>:</p>
        <ul class="space-y-2 text-slate-700">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">initial_state</code> - The starting state for new sessions
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">continuity.enabled</code> - Enable/disable session continuity
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">continuity.timeout</code> - Time in seconds before continuity expires
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">continuity.resume_prompt</code> - Message shown when offering resume
            </li>
        </ul>
    </section>
</div>
@endsection
