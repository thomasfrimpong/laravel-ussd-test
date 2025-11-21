@extends('_layouts.master')

@section('title', 'State')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            State
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">States are the core building blocks of your USSD application. Each state represents a screen or step in your USSD flow.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Creating a State
        </h2>
        <p class="text-slate-700 mb-4">Use the Artisan command to create a new state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">php artisan ussd:state WelcomeState</code></pre>
        </div>
        <p class="text-slate-600 mb-0">This will create a new state class in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">app/Ussd/States/WelcomeState.php</code>.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            State Structure
        </h2>
        <p class="text-slate-700 mb-4">A typical state class looks like this:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class WelcomeState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Welcome to our service!')
            ->option('1', 'View Balance')
            ->option('2', 'Transfer Money')
            ->option('3', 'Exit')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        return $this->decision($input)
            ->equal('1', BalanceState::class)
            ->equal('2', TransferState::class)
            ->equal('3', null) // End session
            ->any(WelcomeState::class); // Default fallback
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            State Methods
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    buildMenu()
                </h3>
                <p class="text-slate-700 mb-0">Builds and returns a Menu instance for this state. This method is called when the user enters the state.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                    </svg>
                    next()
                </h3>
                <p class="text-slate-700 mb-0">Processes user input and returns the next state class name, or null to end the session.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    decision()
                </h3>
                <p class="text-slate-700 mb-0">Returns a Decision instance for creating fluent decision trees based on user input.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"></path>
                    </svg>
                    record
                </h3>
                <p class="text-slate-700 mb-0">Access the Record instance for storing and retrieving session data throughout the flow.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Setting the Initial State
        </h2>
        <p class="text-slate-700 mb-4">The initial state is the entry point of your USSD application. It's the first state that users encounter when they dial your USSD code and start a new session. This state is configured in your <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code> file.</p>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Configuration</h3>
            <p class="text-slate-700 mb-4">The initial state is set using the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">initial_state</code> key in your configuration file:</p>
            
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">return [
    'initial_state' => 'App\\Ussd\\States\\WelcomeState',
    
    'state_namespace' => 'App\\Ussd\\States',
    
    // ... other configuration
];</code></pre>
            </div>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-6 border border-blue-200/50 mb-4">
                <h4 class="text-lg font-bold text-slate-900 mb-2">Important Requirements:</h4>
                <ul class="space-y-2 text-slate-700 mb-0">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        The value must be a <strong>fully qualified class name</strong> (including the complete namespace)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        The class must exist and implement the <code class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 font-mono text-xs">State</code> interface
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Use double backslashes (<code class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 font-mono text-xs">\\</code>) to escape namespace separators in PHP strings
                    </li>
                </ul>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Changing the Initial State</h3>
            <p class="text-slate-700 mb-4">To change the initial state, simply update the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">initial_state</code> value to point to a different state class:</p>
            
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">return [
    // Change from WelcomeState to MainMenuState
    'initial_state' => 'App\\Ussd\\States\\MainMenuState',
    
    // Or use a different namespace
    'initial_state' => 'App\\Services\\Ussd\\States\\HomeState',
    
    // ... other configuration
];</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">How Initial State Works</h3>
            <p class="text-slate-700 mb-4">The initial state plays a crucial role in the USSD session flow:</p>
            
            <div class="space-y-4">
                <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                    <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        New Sessions
                    </h4>
                    <p class="text-slate-700 mb-0">When a user dials your USSD code for the first time, the Machine creates a new session context and sets the current state to the configured initial state. The user then sees the menu from this state.</p>
                </div>

                <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                    <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Session Restart
                    </h4>
                    <p class="text-slate-700 mb-0">When a user chooses to restart their session (via session continuity), the Machine resets the context back to the initial state, clearing all stored data and starting fresh.</p>
                </div>

                <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                    <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                        <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        State Flow
                    </h4>
                    <p class="text-slate-700 mb-0">From the initial state, users navigate through your application by selecting options or providing input, which transitions them to other states. The initial state serves as the root of your state tree.</p>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-xl p-6 border border-amber-200/50">
            <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Best Practices
            </h4>
            <ul class="space-y-2 text-slate-700 mb-0">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Choose a state that provides a clear main menu or welcome message as your initial state
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Ensure your initial state always expects input (<code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-mono text-xs">expectsInput(true)</code>) to allow users to navigate
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Keep the initial state simple and focused - it's the first impression users have of your service
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Test your initial state thoroughly, as it's the most frequently accessed state in your application
                </li>
            </ul>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Response Types: CON vs END
        </h2>
        <p class="text-slate-700 mb-4">USSD responses must be prefixed with either <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">CON</code> (continue) or <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">END</code> (end session). The framework automatically determines this based on whether your menu expects user input.</p>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">CON (Continue) - Expects User Input</h3>
            <p class="text-slate-700 mb-4">Use <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">CON</code> when you want the user to provide input. This keeps the session active and waits for the user's response.</p>
            
            <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-6 border border-blue-200/50 mb-4">
                <h4 class="text-lg font-bold text-slate-900 mb-2">When to Use CON:</h4>
                <ul class="space-y-2 text-slate-700 mb-0">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Displaying menus with options for the user to select
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Asking for user input (phone numbers, amounts, PINs, etc.)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Any state where the user needs to make a selection or provide data
                    </li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class WelcomeState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Welcome to our service!')
            ->option('1', 'View Balance')
            ->option('2', 'Transfer Money')
            ->option('3', 'Exit')
            ->expectsInput(true); // CON response - expects input
    }
}</code></pre>
            </div>
            <p class="text-slate-600 mb-0">The response will be: <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">CON Welcome to our service!\n1. View Balance\n2. Transfer Money\n3. Exit</code></p>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">END (End Session) - Information Only</h3>
            <p class="text-slate-700 mb-4">Use <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">END</code> when you're displaying information only and don't need user input. This terminates the USSD session.</p>
            
            <div class="bg-gradient-to-br from-green-50 to-green-100/50 rounded-xl p-6 border border-green-200/50 mb-4">
                <h4 class="text-lg font-bold text-slate-900 mb-2">When to Use END:</h4>
                <ul class="space-y-2 text-slate-700 mb-0">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Displaying account balance or transaction results
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Showing confirmation messages (e.g., "Transfer successful")
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Error messages that don't require user action
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 text-green-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                        Final states in a flow (success/error screens)
                    </li>
                </ul>
            </div>

            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class BalanceState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        $balance = $this->record->get('balance', '0.00');
        
        return (new Menu())
            ->text('Account Balance')
            ->line('')
            ->text("Your balance: {$balance}")
            ->line('')
            ->text('Thank you for using our service.')
            ->expectsInput(false); // END response - no input needed
    }
}</code></pre>
            </div>
            <p class="text-slate-600 mb-0">The response will be: <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">END Account Balance\n\nYour balance: 1000.00\n\nThank you for using our service.</code></p>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Using the response() Method</h3>
            <p class="text-slate-700 mb-4">The <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">response()</code> method automatically determines CON or END based on the menu's <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">expectsInput()</code> setting:</p>
            
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class MyState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $menu = (new Menu())
            ->text('Select an option:')
            ->option('1', 'Option 1')
            ->option('2', 'Option 2');
        
        // Option 1: Set expectsInput on the menu
        $menu->expectsInput(true); // Will generate CON response
        
        // Option 2: Pass expectsInput to response() method
        // This overrides the menu's setting
        return $this->response($menu, true); // CON response
        // or
        return $this->response($menu, false); // END response
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Direct Response Creation</h3>
            <p class="text-slate-700 mb-4">You can also create responses directly using <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">UssdResponse</code> class for more control:</p>
            
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

use Vendor\LaravelUssd\Support\UssdResponse;

class CustomState extends AbstractState
{
    public function entry(Context $context): UssdResponse
    {
        // Create a CON response (expects input)
        return UssdResponse::continue('Please enter your PIN:');
        
        // Or create an END response (info only)
        return UssdResponse::end('Transaction completed successfully!');
    }
}</code></pre>
            </div>
        </div>

        <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-xl p-6 border border-amber-200/50">
            <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                <svg class="w-5 h-5 text-amber-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Important Notes
            </h4>
            <ul class="space-y-2 text-slate-700 mb-0">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <strong>CON responses</strong> keep the session alive. The user can continue interacting with your application.
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <strong>END responses</strong> terminate the session immediately. The user must start a new session to continue.
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    If you use <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-mono text-xs">expectsInput(false)</code>, make sure your <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-mono text-xs">next()</code> method returns <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-mono text-xs">null</code> since the session will end.
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-amber-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    The default behavior is <code class="bg-amber-100 px-1.5 py-0.5 rounded text-amber-900 font-mono text-xs">expectsInput(true)</code>, so menus will generate CON responses unless explicitly set to false.
                </li>
            </ul>
        </div>
    </section>
</div>
@endsection
