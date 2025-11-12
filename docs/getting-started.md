# Getting Started

1. Install the package:
   ```bash
   composer require catalyst/laravel-ussd
   ```
2. Publish config and stubs:
   ```bash
   php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
   ```
3. Register the USSD route in `routes/api.php`:
   ```php
   Route::post('/ussd', \Vendor\LaravelUssd\Http\Controllers\UssdController::class)
       ->middleware('ussd.normalize');
   ```
4. Create your first state:
   ```bash
   php artisan ussd:state WelcomeState
   ```

Refer to the docs for menu creation, actions, testing, and session continuity.
