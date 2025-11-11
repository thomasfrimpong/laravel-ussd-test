<?php

use Illuminate\Support\Facades\Route;
use Vendor\LaravelUssd\Http\Controllers\UssdController;

Route::post('/ussd', UssdController::class)->name('ussd.handle');
