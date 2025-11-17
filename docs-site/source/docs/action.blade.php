@extends('_layouts.master')

@section('title', 'Action')

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>Action</h1>

    <p>Actions encapsulate side-effect logic that can be invoked from states. They're useful for handling business logic, API calls, database operations, and other tasks that shouldn't be directly in your state classes.</p>

    <h2>Creating an Action</h2>

    <p>Use the Artisan command to create a new action:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>php artisan ussd:action ProcessPayment</code></pre>
    </div>

    <h2>Action Structure</h2>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>&lt;?php

namespace App\Ussd\Actions;

use Vendor\LaravelUssd\Support\AbstractAction;
use Vendor\LaravelUssd\Support\Context;

class ProcessPayment extends AbstractAction
{
    public function handle(Context $context)
    {
        // Your business logic here
        $amount = $context->input;
        $account = $context->get('account_number');

        // Process payment
        $result = $this->paymentService->process($account, $amount);

        if ($result->success) {
            $context->set('payment_id', $result->id);
            return $this->success('Payment processed successfully');
        }

        return $this->error('Payment failed. Please try again.');
    }
}</code></pre>
    </div>

    <h2>Using Actions in States</h2>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>public function processPayment()
{
    $action = new ProcessPayment();
    $result = $action->execute($this->context);

    if ($result->isSuccess()) {
        return $this->next('PaymentSuccessState');
    }

    return $this->menu()
        ->text($result->getMessage())
        ->next('handle');
}</code></pre>
    </div>
</div>
@endsection

