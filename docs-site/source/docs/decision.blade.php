@extends('_layouts.master')

@section('title', 'Decision')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Decision
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">The Decision component allows you to handle user inputs and navigate to different states based on those inputs. It provides a fluent interface for creating decision trees and validating user input.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Understanding Decisions
        </h2>
        <p class="text-slate-700">Decisions are used in the <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">next()</code> method of states to determine which state the user should see next based on their input. The Decision class provides various validation methods that can be chained together to create complex decision logic.</p>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Basic Usage
        </h2>
        <p class="text-slate-700 mb-4">Decisions are typically used in state classes to route users based on their input:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;

class WelcomeState extends AbstractState
{
    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
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
            Decision Methods
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">equal($value, $state)</h3>
                <p class="text-slate-700 mb-3">Checks if the input exactly matches the given value. If true, transitions to the specified state.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->equal('1', MenuState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">numeric($state)</h3>
                <p class="text-slate-700 mb-3">Checks if the input is numeric. Transitions to the specified state if the input contains only numbers.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->numeric(AmountState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">integer($state)</h3>
                <p class="text-slate-700 mb-3">Checks if the input is a valid integer. Transitions to the specified state if the input is a whole number.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->integer(QuantityState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">amount($state)</h3>
                <p class="text-slate-700 mb-3">Validates that the input is a valid monetary amount. Useful for payment or transfer flows.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->amount(PaymentState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">length($min, $max, $state)</h3>
                <p class="text-slate-700 mb-3">Checks if the input length is between the minimum and maximum values (inclusive).</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->length(4, 6, PinState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">phoneNumber($state)</h3>
                <p class="text-slate-700 mb-3">Validates that the input is a valid phone number format.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->phoneNumber(RecipientState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">between($min, $max, $state)</h3>
                <p class="text-slate-700 mb-3">Checks if the numeric input is between the minimum and maximum values (inclusive).</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->between(1, 5, OptionState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">in(array $values, $state)</h3>
                <p class="text-slate-700 mb-3">Checks if the input is one of the values in the provided array.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->in(['yes', 'y', '1'], ConfirmState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">custom(callable $callback, $state)</h3>
                <p class="text-slate-700 mb-3">Allows you to define custom validation logic using a callback function.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->custom(function($input) {
    return str_starts_with($input, 'ACC');
}, AccountState::class);</code></pre>
                </div>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">any($state)</h3>
                <p class="text-slate-700 mb-3">Acts as a catch-all that matches any input. Should be used as the last method in the chain as a fallback.</p>
                <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-lg p-3 overflow-x-auto">
                    <pre class="text-slate-100 text-xs font-mono"><code>$this->decision($input)->any(ErrorState::class);</code></pre>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Chaining Methods
        </h2>
        <p class="text-slate-700 mb-4">Decision methods can be chained together to create complex decision trees. The first matching condition will determine the next state:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    return $this->decision($input)
        ->equal('0', WelcomeState::class) // Return to main menu
        ->equal('99', null) // End session
        ->between(1, 5, SelectedOptionState::class) // Valid option range
        ->numeric(InvalidInputState::class) // Numeric but out of range
        ->any(ErrorState::class); // Any other input
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Complete Example
        </h2>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\States;

use Vendor\LaravelUssd\Support\AbstractState;
use Vendor\LaravelUssd\Support\Context;
use Vendor\LaravelUssd\Support\UssdResponse;

class TransferAmountState extends AbstractState
{
    public function entry(Context $context): UssdResponse
    {
        return UssdResponse::continue(
            "Enter amount to transfer:\n" .
            "Minimum: 10\n" .
            "Maximum: 5000"
        );
    }

    public function next(Context $context, string $input): ?string
    {
        $this->setContext($context);
        // Store amount in context for later use
        $this->record->set('amount', $input);

        return $this->decision($input)
            ->amount(ConfirmTransferState::class)
            ->between(10, 5000, ConfirmTransferState::class)
            ->numeric(InvalidAmountState::class)
            ->any(ErrorState::class);
    }
}</code></pre>
        </div>
    </section>
</div>
@endsection
