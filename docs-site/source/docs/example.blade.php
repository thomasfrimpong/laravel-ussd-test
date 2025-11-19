@extends('_layouts.master')

@section('title', 'Complete Example')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Complete Example
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">This guide walks you through building a complete USSD application from scratch. We'll create a simple money transfer service that demonstrates all the core concepts.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 1: Installation
        </h2>
        <p class="text-slate-700 mb-4">First, install the package via Composer:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">composer require catalysteria/laravel-ussd</code></pre>
        </div>
        <p class="text-slate-700 mb-4">Publish the configuration:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">php artisan vendor:publish --provider="Vendor\LaravelUssd\Providers\LaravelUssdServiceProvider"</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 2: Register the Route
        </h2>
        <p class="text-slate-700 mb-4">Add the USSD route to <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">routes/api.php</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">use Illuminate\Support\Facades\Route;

Route::post('/ussd', \Vendor\LaravelUssd\Http\Controllers\UssdController::class)
    ->middleware('ussd.normalize');</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 3: Create the Welcome State
        </h2>
        <p class="text-slate-700 mb-4">Create the initial state that users see when they dial the USSD code:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">php artisan ussd:state WelcomeState</code></pre>
        </div>
        <p class="text-slate-700 mb-4">Now implement the WelcomeState:</p>
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
            ->text('Welcome to Money Transfer Service')
            ->line('')
            ->option('1', 'Send Money')
            ->option('2', 'Check Balance')
            ->option('3', 'Exit')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('1', SendMoneyState::class)
            ->equal('2', CheckBalanceState::class)
            ->equal('3', null) // End session
            ->any(WelcomeState::class); // Invalid input, show menu again
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 4: Create the Send Money Flow
        </h2>
        <p class="text-slate-700 mb-4">Create states for the money transfer flow. First, create the recipient state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">php artisan ussd:state SendMoneyState
php artisan ussd:state RecipientState
php artisan ussd:state AmountState
php artisan ussd:state ConfirmTransferState</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 5: Implement SendMoneyState
        </h2>
        <p class="text-slate-700 mb-4">This state initiates the transfer flow:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class SendMoneyState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Send Money')
            ->line('')
            ->text('Enter recipient phone number:')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Validate phone number and move to next state
        return $this->decision($input)
            ->phoneNumber(RecipientState::class)
            ->any(SendMoneyState::class); // Invalid phone, try again
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 6: Implement RecipientState
        </h2>
        <p class="text-slate-700 mb-4">Store the recipient and ask for amount:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class RecipientState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        // Retrieve recipient from previous state
        $recipient = $this->record->get('recipient', '');
        
        return (new Menu())
            ->text("Recipient: {$recipient}")
            ->line('')
            ->text('Enter amount to send:')
            ->text('Minimum: 10')
            ->text('Maximum: 5000')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Store recipient from previous input
        // Note: In a real app, you'd get this from the previous state's input
        // For this example, we'll store it when transitioning
        if (!$this->record->has('recipient')) {
            // This would come from the previous state in a real implementation
            $this->record->set('recipient', $context->data['previous_input'] ?? '');
        }
        
        // Validate amount
        return $this->decision($input)
            ->amount(AmountState::class)
            ->between(10, 5000, AmountState::class)
            ->numeric(SendMoneyState::class) // Valid number but out of range
            ->any(SendMoneyState::class); // Invalid input
    }
}</code></pre>
        </div>
        <p class="text-slate-700 mb-0">Actually, let's fix the flow. The recipient should be stored when we transition from SendMoneyState:</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 7: Complete Flow Implementation
        </h2>
        <p class="text-slate-700 mb-4">Here's the complete implementation with proper data flow:</p>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">SendMoneyState (Updated)</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class SendMoneyState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Send Money')
            ->line('')
            ->text('Enter recipient phone number:')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Validate phone number using decision
        $nextState = $this->decision($input)
            ->phoneNumber(RecipientState::class)
            ->any(SendMoneyState::class); // Invalid phone, show menu again
        
        // If valid, store the recipient before transitioning
        if ($nextState === RecipientState::class) {
            $this->record->set('recipient', $input);
        }
        
        return $nextState;
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">RecipientState</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class RecipientState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        $recipient = $this->record->get('recipient', '');
        
        return (new Menu())
            ->text("Recipient: {$recipient}")
            ->line('')
            ->text('Enter amount to send:')
            ->text('Minimum: 10')
            ->text('Maximum: 5000')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Validate amount using decision chain
        $nextState = $this->decision($input)
            ->amount(ConfirmTransferState::class)
            ->between(10, 5000, ConfirmTransferState::class)
            ->numeric(RecipientState::class) // Valid number but out of range
            ->any(RecipientState::class); // Invalid input
        
        // If valid amount, store it before transitioning
        if ($nextState === ConfirmTransferState::class) {
            $this->record->set('amount', $input);
        }
        
        return $nextState;
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">ConfirmTransferState</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class ConfirmTransferState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        
        // Retrieve stored data
        $recipient = $this->record->get('recipient');
        $amount = $this->record->get('amount');
        
        return (new Menu())
            ->text('Confirm Transfer')
            ->line('')
            ->text("To: {$recipient}")
            ->text("Amount: {$amount}")
            ->line('')
            ->option('1', 'Confirm')
            ->option('2', 'Cancel')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('1', TransferSuccessState::class) // Confirm - process transfer
            ->equal('2', WelcomeState::class) // Cancel - return to main menu
            ->any(ConfirmTransferState::class); // Invalid input - show again
        
        // Note: In a real app, you'd process the transfer in an Action
        // before transitioning to TransferSuccessState
    }
}</code></pre>
            </div>
        </div>

        <div>
            <h3 class="text-xl font-bold text-slate-900 mb-3">TransferSuccessState</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class TransferSuccessState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        $amount = $this->record->get('amount');
        $recipient = $this->record->get('recipient');
        
        return (new Menu())
            ->text('Transfer Successful!')
            ->line('')
            ->text("You sent {$amount} to {$recipient}")
            ->line('')
            ->text('Thank you for using our service.')
            ->expectsInput(false); // End session
    }

    public function next(Context $context, string $input): ?string
    {
        // This state doesn't expect input, so this shouldn't be called
        return null;
    }
}</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 8: Create CheckBalanceState
        </h2>
        <p class="text-slate-700 mb-4">Create a simple balance check state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;
use Vendor\LaravelUssd\Menu\Menu;

class CheckBalanceState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        // In a real app, you'd fetch balance from database/API
        $balance = 1000.00; // Example balance
        
        return (new Menu())
            ->text('Account Balance')
            ->line('')
            ->text("Your balance: {$balance}")
            ->line('')
            ->text('Thank you for using our service.')
            ->expectsInput(false); // End session
    }

    public function next(Context $context, string $input): ?string
    {
        return null; // End session
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 9: Update Configuration
        </h2>
        <p class="text-slate-700 mb-4">Set the initial state in <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">return [
    'initial_state' => 'App\\Ussd\\States\\WelcomeState',
    
    // ... other configuration
];</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 10: Testing the Flow
        </h2>
        <p class="text-slate-700 mb-4">Test your USSD application by sending POST requests to your endpoint:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">// Initial request (no input)
POST /api/ussd
{
    "sessionId": "12345",
    "msisdn": "233241234567",
    "text": ""
}

// User selects option 1 (Send Money)
POST /api/ussd
{
    "sessionId": "12345",
    "msisdn": "233241234567",
    "text": "1"
}

// User enters recipient phone
POST /api/ussd
{
    "sessionId": "12345",
    "msisdn": "233241234567",
    "text": "233241234568"
}

// User enters amount
POST /api/ussd
{
    "sessionId": "12345",
    "msisdn": "233241234567",
    "text": "100"
}

// User confirms transfer
POST /api/ussd
{
    "sessionId": "12345",
    "msisdn": "233241234567",
    "text": "1"
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Complete File Structure
        </h2>
        <p class="text-slate-700 mb-4">Your final file structure should look like this:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">app/
└── Ussd/
    └── States/
        ├── WelcomeState.php
        ├── SendMoneyState.php
        ├── RecipientState.php
        ├── AmountState.php
        ├── ConfirmTransferState.php
        ├── TransferSuccessState.php
        └── CheckBalanceState.php

routes/
└── api.php

config/
└── ussd.php</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Key Concepts Demonstrated
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    States
                </h3>
                <p class="text-slate-700 mb-0">Each screen in the USSD flow is a state. States handle menu display and user input processing.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    Menus
                </h3>
                <p class="text-slate-700 mb-0">Menus are built using the fluent Menu API to create user-friendly USSD interfaces.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                    Decisions
                </h3>
                <p class="text-slate-700 mb-0">The Decision class validates user input and routes to the appropriate next state.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Records
                </h3>
                <p class="text-slate-700 mb-0">Records store data across states, allowing you to collect information throughout the session.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Next Steps
        </h2>
        <ul class="space-y-3 text-slate-700">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Add error handling and validation for edge cases
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Create Actions for business logic (e.g., ProcessTransferAction)
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Integrate with payment gateways or APIs
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Add session continuity for better user experience
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Write tests for your states and flows
            </li>
        </ul>
    </section>
</div>
@endsection

