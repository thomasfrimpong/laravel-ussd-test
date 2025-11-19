@extends('_layouts.master')

@section('title', 'Record')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Record
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">The Record component is used to store and retrieve data during a USSD session. It connects with the session storage to save data tied to a unique session ID, ensuring data persistence throughout the session lifecycle.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Understanding Records
        </h2>
        <p class="text-slate-700">Records allow you to store user input and other data collected during a USSD session. This data persists across state transitions and can be accessed from any state within the same session. The data is automatically cleared when the session ends.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Basic Usage
        </h2>
        <p class="text-slate-700 mb-4">Records are accessed through the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">$this->record</code> property in state classes:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;

class AmountState extends AbstractState
{
    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        // Store the amount
        $this->record->set('amount', $input);
        
        return ConfirmState::class;
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Record Methods
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">set($key, $value)</h3>
                <p class="text-slate-700 mb-3">Stores a single value with the specified key. The value will be available throughout the session.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->record->set('amount', 100);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">setMultiple(array $data)</h3>
                <p class="text-slate-700 mb-3">Stores multiple key-value pairs at once. Useful for storing related data together.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->record->setMultiple([
    'recipient' => '233241234567',
    'amount' => 100
]);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">get($key, $default = null)</h3>
                <p class="text-slate-700 mb-3">Retrieves a stored value by key. Returns the default value if the key doesn't exist.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$amount = $this->record->get('amount');</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">getMultiple(array $keys)</h3>
                <p class="text-slate-700 mb-3">Retrieves multiple values at once by providing an array of keys. Returns an associative array.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$data = $this->record->getMultiple(['amount', 'recipient']);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">has($key)</h3>
                <p class="text-slate-700 mb-3">Checks if a key exists in the stored data. Returns <code class="bg-slate-100 px-1.5 py-0.5 rounded text-slate-800 font-mono text-xs">true</code> if the key exists.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>if ($this->record->has('amount')) {
    // ...
}</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">delete($key)</h3>
                <p class="text-slate-700 mb-3">Removes a stored value by key. Useful for clearing specific data when it's no longer needed.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->record->delete('temporary_data');</code></pre>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Using Records in States
        </h2>
        <p class="text-slate-700 mb-4">Records are commonly used to collect data across multiple states and then use that data in a final state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;

class RecipientState extends AbstractState
{
    public function entry(Context $context): UssdResponse
    {
        return UssdResponse::continue('Enter recipient phone number:');
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        $this->record->set('recipient', $input);
        return AmountState::class;
    }
}

class AmountState extends AbstractState
{
    public function entry(Context $context): UssdResponse
    {
        return UssdResponse::continue('Enter amount:');
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        $this->record->set('amount', $input);
        return ConfirmState::class;
    }
}

class ConfirmState extends AbstractState
{
    public function entry(Context $context): UssdResponse
    {
        $this->setContext($context);
        // Retrieve stored data
        $recipient = $this->record->get('recipient');
        $amount = $this->record->get('amount');

        return UssdResponse::continue(
            "Confirm Transfer:\n" .
            "To: {$recipient}\n" .
            "Amount: {$amount}\n\n" .
            "1. Confirm\n" .
            "2. Cancel"
        );
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        if ($input === '1') {
            // Get all stored data for processing
            $transferData = $this->record->getMultiple(['recipient', 'amount']);
            // Process transfer...
            return ProcessTransferState::class;
        }

        return WelcomeState::class;
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Data Persistence
        </h2>
        <p class="text-slate-700 mb-4">Record data is stored in the session context and persists across state transitions within the same USSD session. The data is automatically cleared when:</p>
        <ul class="space-y-2 text-slate-700">
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                The session ends (user exits or session times out)
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                The session is explicitly cleared
            </li>
            <li class="flex items-start">
                <svg class="w-5 h-5 text-primary-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                The session expires based on the configured timeout
            </li>
        </ul>
        <p class="text-slate-700 mb-0 mt-4">This ensures that data collected during a session is available throughout the entire flow but doesn't persist beyond the session lifecycle.</p>
    </section>
</div>
@endsection

