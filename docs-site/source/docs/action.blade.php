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
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">public function next(Context $context, string $input): ?string
{
    $this->setContext($context);
    
    $action = new ProcessPayment();
    $result = $action->handle($context, $input);

    if ($result['success']) {
        return PaymentSuccessState::class;
    }

    // Handle error case
    return ErrorState::class;
}</code></pre>
        </div>
    </section>
</div>
@endsection
