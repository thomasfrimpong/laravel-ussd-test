@extends('_layouts.master')

@section('title', 'Action')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Action
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">Actions encapsulate side-effect logic that can be invoked from states. They're useful for handling business logic, API calls, database operations, and other tasks that shouldn't be directly in your state classes.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Creating an Action
        </h2>
        <p class="text-slate-700 mb-4">Use the Artisan command to create a new action:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono"><code class="text-slate-100">php artisan ussd:action ProcessPayment</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Action Structure
        </h2>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">&lt;?php

namespace App\Ussd\Actions;

use Vendor\LaravelUssd\Support\AbstractAction;
use Vendor\LaravelUssd\Support\Context;

class ProcessPayment extends AbstractAction
{
    public function handle(Context $context, string $input): mixed
    {
        // Your business logic here
        $amount = $input;
        $account = $context->data['account_number'] ?? null;

        // Process payment
        $result = $this->paymentService->process($account, $amount);

        if ($result->success) {
            $context->data['payment_id'] = $result->id;
            return ['success' => true, 'message' => 'Payment processed successfully'];
        }

        return ['success' => false, 'message' => 'Payment failed. Please try again.'];
    }
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Using Actions in States
        </h2>
        <p class="text-slate-700 mb-4">Actions are <strong>called</strong> from within your State's <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">next()</code> method to perform business logic. After calling an action, you must return a <strong>State</strong> class name, not an Action class name.</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    
    // Call the action to perform business logic
    $action = new ProcessPayment();
    $result = $action->handle($context, $input);

    // IMPORTANT: Return a STATE class name, not an Action class name
    if ($result['success']) {
        return PaymentSuccessState::class; // ✅ Correct: State class
    }

    // Handle error case - also return a State
    return ErrorState::class; // ✅ Correct: State class
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-red-500 to-red-600 rounded-full mr-4"></span>
            Common Mistake: Returning Action Instead of State
        </h2>
        <div class="bg-gradient-to-br from-red-50 to-red-100/50 rounded-xl p-6 border border-red-200/50 mb-4">
            <h4 class="text-lg font-bold text-slate-900 mb-2 flex items-center">
                <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                ⚠️ Important: Never Return Action Class Names
            </h4>
            <p class="text-slate-700 mb-3">The <code class="bg-red-100 px-1.5 py-0.5 rounded text-red-900 font-mono text-xs">next()</code> method must return a <strong>State</strong> class name (string), never an Action class name. Returning an Action will cause a type error:</p>
            <p class="text-slate-600 text-sm mb-0 font-mono bg-red-50 p-2 rounded border border-red-200">Machine::resolveState(): Return value must be of type State, Action returned</p>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-red-900 mb-3">❌ Incorrect - Returning Action Class</h3>
            <div class="bg-gradient-to-br from-red-900 to-red-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-red-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    
    // ❌ WRONG: Returning an Action class name
    return ProcessPayment::class; // This will cause an error!
    
    // ❌ WRONG: Returning an Action instance
    return new ProcessPayment(); // This will also cause an error!
}</code></pre>
            </div>
        </div>

        <div class="mb-6">
            <h3 class="text-xl font-bold text-green-900 mb-3">✅ Correct - Call Action, Return State</h3>
            <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
                <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    
    // ✅ CORRECT: Call the action to perform business logic
    $action = new ProcessPayment();
    $result = $action->handle($context, $input);
    
    // ✅ CORRECT: Return a STATE class name based on the result
    if ($result['success'] ?? false) {
        return PaymentSuccessState::class; // State class name
    }
    
    return PaymentErrorState::class; // State class name
}</code></pre>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 rounded-xl p-6 border border-blue-200/50">
            <h4 class="text-lg font-bold text-slate-900 mb-2">Key Points to Remember:</h4>
            <ul class="space-y-2 text-slate-700 mb-0">
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <strong>Actions are called</strong> (invoked) within states to perform business logic
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <strong>States are returned</strong> from <code class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 font-mono text-xs">next()</code> to navigate the flow
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    The return type of <code class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 font-mono text-xs">next()</code> is <code class="bg-blue-100 px-1.5 py-0.5 rounded text-blue-900 font-mono text-xs">?string</code> - a State class name or null
                </li>
                <li class="flex items-start">
                    <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    Use actions for side effects (API calls, database operations), then return the appropriate next state
                </li>
            </ul>
        </div>
    </section>
</div>
@endsection
