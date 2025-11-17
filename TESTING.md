# Quick Testing Guide

## Quick Start

1. **Install dependencies:**

   ```bash
   composer install 
   ```

2. **Run tests:**
   ```bash
   composer test
   ```

## Test in a Laravel App

1. **Add to test app's `composer.json`:**

   ```json
   {
     "repositories": [
       {
         "type": "path",
         "url": "../laravel-ussd"
       }
     ],
     "require": {
       "catalysteria/laravel-ussd": "@dev"
     }
   }
   ```

2. **Install and test:**

   ```bash
   composer update catalysteria/laravel-ussd
   php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
   php artisan ussd:state WelcomeState
   ```

3. **Test the endpoint:**
   ```bash
   curl -X POST http://localhost:8000/ussd \
     -d "sessionId=test" \
     -d "msisdn=+1234567890" \
     -d "text="
   ```

For detailed testing instructions, see `docs/testing.md`.
