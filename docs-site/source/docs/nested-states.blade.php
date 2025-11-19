@extends('_layouts.master')

@section('title', 'Nested States')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Nested States
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">Nested states allow you to create hierarchical menu structures and sub-menus within your USSD application. This enables complex navigation flows while maintaining clean, organized code.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Understanding Nested States
        </h2>
        <p class="text-slate-700 mb-4">Nested states are states that exist within a parent state's flow. They allow you to:</p>
        <ul class="space-y-2 text-slate-700 mb-6">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Create sub-menus and multi-level navigation
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Organize related functionality into logical groups
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Implement "back" navigation to return to parent states
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
                Maintain context and data across nested flows
            </li>
        </ul>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Basic Nested State Example
        </h2>
        <p class="text-slate-700 mb-4">Let's create a banking application with nested states for account management:</p>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Main Menu State (Parent)</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

class MainMenuState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Main Menu')
            ->line('')
            ->option('1', 'Account Services')
            ->option('2', 'Transfer Money')
            ->option('3', 'Bill Payments')
            ->option('0', 'Exit')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('1', AccountServicesState::class) // Nested state
            ->equal('2', TransferState::class)
            ->equal('3', BillPaymentsState::class)
            ->equal('0', null) // End session
            ->any(MainMenuState::class);
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Account Services State (Nested)</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Menu\Menu;

class AccountServicesState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Account Services')
            ->line('')
            ->option('1', 'Check Balance')
            ->option('2', 'Mini Statement')
            ->option('3', 'Account Details')
            ->option('0', 'Back to Main Menu')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('1', CheckBalanceState::class)
            ->equal('2', MiniStatementState::class)
            ->equal('3', AccountDetailsState::class)
            ->equal('0', MainMenuState::class) // Return to parent
            ->any(AccountServicesState::class);
    }
}</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Multi-Level Nesting
        </h2>
        <p class="text-slate-700 mb-4">You can nest states multiple levels deep. Here's an example with three levels:</p>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Level 1: Main Menu</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">MainMenuState
  └─> AccountServicesState (Level 2)
        └─> AccountDetailsState (Level 3)</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Level 2: Account Services</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class AccountServicesState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Account Services')
            ->line('')
            ->option('1', 'Account Details')
            ->option('2', 'Transaction History')
            ->option('0', 'Back')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('1', AccountDetailsState::class) // Level 3
            ->equal('2', TransactionHistoryState::class)
            ->equal('0', MainMenuState::class) // Back to Level 1
            ->any(AccountServicesState::class);
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Level 3: Account Details</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class AccountDetailsState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        $accountNumber = $this->record->get('account_number', 'N/A');
        
        return (new Menu())
            ->text('Account Details')
            ->line('')
            ->text("Account: {$accountNumber}")
            ->text("Type: Savings")
            ->text("Status: Active")
            ->line('')
            ->option('0', 'Back to Account Services')
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('0', AccountServicesState::class) // Back to Level 2
            ->any(AccountDetailsState::class);
    }
}</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Navigation Patterns
        </h2>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">1. Back Navigation</h3>
            <p class="text-slate-700 mb-4">Always provide a way for users to go back to the previous level. Common patterns:</p>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">// Option 0 for "Back"
->option('0', 'Back to Main Menu')

// In next() method
->equal('0', MainMenuState::class)

// Or use a dedicated BackState
->equal('0', BackState::class)</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">2. Breadcrumb Navigation</h3>
            <p class="text-slate-700 mb-4">Store navigation history in the Record to enable breadcrumb-style navigation:</p>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class AccountServicesState extends AbstractState
{
    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Store parent state before navigating to child
        $this->record->set('previous_state', MainMenuState::class);
        
        return $this->decision($input)
            ->equal('1', AccountDetailsState::class)
            ->equal('0', $this->record->get('previous_state', MainMenuState::class))
            ->any(AccountServicesState::class);
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">3. Direct Home Navigation</h3>
            <p class="text-slate-700 mb-4">Allow users to jump directly to the main menu from any nested state:</p>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class AccountDetailsState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        return (new Menu())
            ->text('Account Details')
            ->line('')
            ->text('Account information...')
            ->line('')
            ->option('0', 'Back')
            ->option('*', 'Main Menu') // Quick home navigation
            ->expectsInput();
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        return $this->decision($input)
            ->equal('0', AccountServicesState::class)
            ->equal('*', MainMenuState::class) // Jump to home
            ->any(AccountDetailsState::class);
    }
}</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Data Flow in Nested States
        </h2>
        <p class="text-slate-700 mb-4">Data stored in the Record persists across all nested states. This allows you to:</p>
        
        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Storing Data at Parent Level</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class MainMenuState extends AbstractState
{
    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        
        // Store user selection for use in nested states
        if ($input === '1') {
            $this->record->set('selected_service', 'account');
        }
        
        return $this->decision($input)
            ->equal('1', AccountServicesState::class)
            ->any(MainMenuState::class);
    }
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Accessing Data in Nested States</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

class AccountServicesState extends AbstractState
{
    protected function buildMenu(Context $context): Menu
    {
        $this->setContext($context);
        
        // Access data stored in parent state
        $service = $this->record->get('selected_service', 'unknown');
        
        return (new Menu())
            ->text("Account Services ({$service})")
            ->line('')
            ->option('1', 'Check Balance')
            ->option('0', 'Back')
            ->expectsInput();
    }
}</code></pre>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Best Practices
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Limit Nesting Depth
                </h3>
                <p class="text-slate-700 mb-0">Keep nesting to 2-3 levels maximum. Deeper nesting can confuse users and make navigation difficult.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Always Provide Back Option
                </h3>
                <p class="text-slate-700 mb-0">Every nested state should have a way to return to the parent state. Use option '0' or '*' for back navigation.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Clear Menu Labels
                </h3>
                <p class="text-slate-700 mb-0">Use descriptive labels that indicate the relationship between parent and child states (e.g., "Back to Main Menu").</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2 flex items-center">
                    <svg class="w-5 h-5 text-primary-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Use Record for Context
                </h3>
                <p class="text-slate-700 mb-0">Store navigation context and user selections in the Record so nested states can access parent state data.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Complete Example: Banking App with Nested States
        </h2>
        <p class="text-slate-700 mb-4">Here's a complete example showing a banking application with nested states:</p>
        
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">MainMenuState
  ├─> AccountServicesState
  │     ├─> CheckBalanceState
  │     ├─> MiniStatementState
  │     └─> AccountDetailsState
  │           └─> AccountSettingsState
  ├─> TransferState
  │     ├─> RecipientState
  │     └─> AmountState
  └─> BillPaymentsState
        ├─> ElectricityState
        ├─> WaterState
        └─> InternetState</code></pre>
        </div>
        
        <p class="text-slate-700 mb-0">This structure allows users to navigate through complex menus while maintaining clear navigation paths and data context throughout the session.</p>
    </section>
</div>
@endsection

