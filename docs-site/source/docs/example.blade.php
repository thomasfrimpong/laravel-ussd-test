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
        
        // Handle confirmation
        if ($input === '1') {
            // Call an action to process the transfer
            // Actions are called (invoked) to perform business logic
            $action = new \App\Ussd\Actions\ProcessTransferAction();
            $result = $action->handle($context, $input);
            
            // IMPORTANT: Return a STATE class name based on action result
            // Never return the Action class name (e.g., ProcessTransferAction::class)
            return $result['success'] ?? false
                ? TransferSuccessState::class  // ✅ State class name
                : TransferErrorState::class;   // ✅ State class name
        }
        
        // Handle cancellation
        if ($input === '2') {
            return WelcomeState::class; // ✅ State class name
        }
        
        // Invalid input - show again
        return ConfirmTransferState::class; // ✅ State class name
    }
    
    // Alternative using decision() helper (when you don't need to call actions):
    // public function next(Context $context, string $input): ?string
    // {
    //     $this->setContext($context);
    //     
    //     return $this->decision($input)
    //         ->equal('1', TransferSuccessState::class)
    //         ->equal('2', WelcomeState::class)
    //         ->any(ConfirmTransferState::class);
    // }
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
            Step 8: Using Actions for Business Logic
        </h2>
        <p class="text-slate-700 mb-4">To process the transfer, create an Action to handle the business logic. Actions are <strong>called</strong> from states, not returned as navigation targets.</p>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Create the ProcessTransferAction</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">php artisan ussd:action ProcessTransferAction</code></pre>
            </div>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\Actions;

use Vendor\LaravelUssd\Support\AbstractAction;
use Vendor\LaravelUssd\Support\Context;

class ProcessTransferAction extends AbstractAction
{
    public function handle(Context $context, string $input): mixed
    {
        // Get transfer details from session
        $record = new \Vendor\LaravelUssd\Support\Record($context);
        $recipient = $record->get('recipient');
        $amount = $record->get('amount');
        
        // Perform the transfer (API call, database update, etc.)
        // $result = $this->transferService->process($recipient, $amount);
        
        // Return result that the state can use to determine next step
        return [
            'success' => true,
            'transaction_id' => 'TXN123',
            'message' => 'Transfer processed successfully'
        ];
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Update ConfirmTransferState to Use the Action</h3>
            <p class="text-slate-700 mb-3">Now update the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">ConfirmTransferState::next()</code> method to call the action and return the appropriate State:</p>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    
    if ($input === '1') {
        // ✅ CORRECT: Call the action to perform business logic
        $action = new \App\Ussd\Actions\ProcessTransferAction();
        $result = $action->handle($context, $input);
        
        // ✅ CORRECT: Return a STATE class name based on the result
        // Never return ProcessTransferAction::class (that would be wrong!)
        return ($result['success'] ?? false)
            ? TransferSuccessState::class  // State class name
            : TransferErrorState::class;   // State class name
    }
    
    if ($input === '2') {
        return WelcomeState::class; // Cancel - return to main menu
    }
    
    return ConfirmTransferState::class; // Invalid input - show again
}</code></pre>
            </div>
        </div>

        <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-6 border border-red-200/50">
            <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Critical: Never Return Action Class Names
            </h4>
            <p class="text-slate-700 mb-2">The <code class="bg-red-100 px-1.5 py-0.5 rounded text-red-900 font-mono text-xs">next()</code> method must return a <strong>State</strong> class name, never an Action class name. Common mistakes:</p>
            <ul class="space-y-1 text-slate-700 mb-0 text-sm">
                <li class="flex items-start">
                    <span class="text-red-600 mr-2">❌</span>
                    <code class="bg-red-100 px-1.5 py-0.5 rounded text-red-900 font-mono text-xs">return ProcessTransferAction::class;</code> - Wrong! Returns Action, not State
                </li>
                <li class="flex items-start">
                    <span class="text-red-600 mr-2">❌</span>
                    <code class="bg-red-100 px-1.5 py-0.5 rounded text-red-900 font-mono text-xs">return new ProcessTransferAction();</code> - Wrong! Returns instance, not class name
                </li>
                <li class="flex items-start">
                    <span class="text-green-600 mr-2">✅</span>
                    <code class="bg-green-100 px-1.5 py-0.5 rounded text-green-900 font-mono text-xs">$action->handle(); return TransferSuccessState::class;</code> - Correct! Call action, return State
                </li>
            </ul>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Step 9: Create CheckBalanceState
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
            Step 10: Update Configuration
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
            Step 11: Testing the Flow
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

