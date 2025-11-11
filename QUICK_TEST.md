# Quick Testing Guide

## Step 1: Install Dependencies

```bash
cd laravel-ussd
composer install
```

## Step 2: Run Package Tests

```bash
# Run all tests
composer test

# Or directly
vendor/bin/phpunit

# Run specific test suite
vendor/bin/phpunit tests/Unit
vendor/bin/phpunit tests/Feature
```

## Step 3: Test in a Real Laravel App

### Option A: Local Path (Recommended for Development)

1. **Create a test Laravel app** (in a sibling directory):
   ```bash
   cd ..
   composer create-project laravel/laravel test-ussd-app
   cd test-ussd-app
   ```

2. **Add package as local path** in `composer.json`:
   ```json
   {
       "repositories": [
           {
               "type": "path",
               "url": "../laravel-ussd"
           }
       ],
       "require": {
           "vendor/laravel-ussd": "@dev"
       }
   }
   ```

3. **Install the package**:
   ```bash
   composer update vendor/laravel-ussd
   ```

4. **Publish config**:
   ```bash
   php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider" --tag=ussd-config
   ```

5. **Create a test state**:
   ```bash
   php artisan ussd:state WelcomeState
   ```

6. **Edit the generated state** (`app/Ussd/States/WelcomeState.php`):
   ```php
   protected function buildMenu(Context $context): Menu
   {
       return (new Menu())
           ->text('Welcome!')
           ->option('1', 'View Balance')
           ->option('2', 'Transfer');
   }

   public function next(Context $context, string $input): ?string
   {
       return null; // End session for now
   }
   ```

7. **Update config** (`config/ussd.php`):
   ```php
   'initial_state' => 'App\\Ussd\\States\\WelcomeState',
   ```

8. **Test the endpoint**:
   ```bash
   php artisan serve
   ```

   Then test with curl:
   ```bash
   curl -X POST http://localhost:8000/ussd \
     -H "Content-Type: application/x-www-form-urlencoded" \
     -d "sessionId=test123" \
     -d "msisdn=+1234567890" \
     -d "serviceCode=*123#" \
     -d "text="
   ```

   Expected response: `CON Welcome!\n1. View Balance\n2. Transfer`

## Step 4: Verify Everything Works

✅ **Package Tests Pass**: `composer test`  
✅ **Artisan Commands Work**: `php artisan ussd:state TestState`  
✅ **HTTP Endpoint Responds**: Test with curl/Postman  
✅ **Session Persists**: Make multiple requests with same sessionId  
✅ **Continuity Works**: Test resume/restart functionality  

## Common Issues

**"Class not found" errors:**
- Run `composer dump-autoload` in both package and test app

**Tests fail:**
- Ensure PHP 8.3+ is installed
- Check that Orchestra Testbench is installed: `composer require --dev orchestra/testbench`

**Route not found:**
- Check that service provider is registered
- Verify routes are loaded: `php artisan route:list`

## Next Steps

Once all tests pass:
1. ✅ Review code quality
2. ✅ Update README with examples
3. ✅ Tag a version: `git tag v1.0.0`
4. ✅ Publish to Packagist

