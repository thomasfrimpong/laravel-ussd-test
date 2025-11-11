# Testing Guide

This guide explains how to test the Laravel USSD package before publishing it.

## Prerequisites

1. **Install Dependencies**
   ```bash
   composer install
   ```

2. **Ensure PHPUnit is Available**
   The package uses PHPUnit 11.0 for testing. Make sure you have PHP 8.3+ installed.

## Running Tests

### Run All Tests
```bash
composer test
# or
vendor/bin/phpunit
```

### Run Specific Test Suites
```bash
# Run only unit tests
vendor/bin/phpunit tests/Unit

# Run only feature tests
vendor/bin/phpunit tests/Feature

# Run a specific test file
vendor/bin/phpunit tests/Feature/UssdFlowTest.php
```

### Run with Coverage
```bash
vendor/bin/phpunit --coverage-html coverage
```

## Test Structure

### Unit Tests (`tests/Unit/`)
Test individual components in isolation:
- `MenuTest.php` - Menu builder functionality
- `UssdResponseTest.php` - Response formatting

### Feature Tests (`tests/Feature/`)
Test complete flows and integrations:
- `UssdFlowTest.php` - Basic USSD flow testing
- `SessionContinuityTest.php` - Session resume functionality

### Test Fixtures (`tests/Fixtures/`)
Reusable test states and actions:
- `WelcomeState.php` - Sample state for testing

### Test Support (`tests/Support/`)
Helper classes for testing:
- `UssdTestHarness.php` - Utility for simulating USSD sessions

## Testing in a Real Laravel Application

### Method 1: Local Path Repository

1. **Create a Test Laravel Application**
   ```bash
   composer create-project laravel/laravel test-ussd-app
   cd test-ussd-app
   ```

2. **Add Package as Local Path**
   Edit `composer.json` in your test app:
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

3. **Install Package**
   ```bash
   composer update vendor/laravel-ussd
   ```

4. **Publish Configuration**
   ```bash
   php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
   ```

5. **Create Test States**
   ```bash
   php artisan ussd:state WelcomeState
   php artisan ussd:state MenuState
   ```

6. **Test the Route**
   ```bash
   php artisan serve
   ```
   
   Then test with a tool like Postman or curl:
   ```bash
   curl -X POST http://localhost:8000/ussd \
     -d "sessionId=test123" \
     -d "msisdn=+1234567890" \
     -d "serviceCode=*123#" \
     -d "text="
   ```

### Method 2: Using Orchestra Testbench

The package already uses Orchestra Testbench for isolated testing. You can extend the test suite:

```php
use Vendor\LaravelUssd\Tests\TestCase;

class MyCustomTest extends TestCase
{
    public function test_something(): void
    {
        // Your test code
    }
}
```

## Writing New Tests

### Example: Testing a Custom State

```php
<?php

namespace Vendor\LaravelUssd\Tests\Feature;

use Vendor\LaravelUssd\Machine\Machine;
use Vendor\LaravelUssd\Tests\TestCase;

class CustomStateTest extends TestCase
{
    public function test_custom_state_flow(): void
    {
        $machine = $this->app->make(Machine::class);

        $response = $machine->handle([
            'sessionId' => 'test',
            'msisdn' => '+1234567890',
            'serviceCode' => '*123#',
            'input' => '',
        ]);

        $this->assertStringStartsWith('CON', (string) $response);
    }
}
```

## Testing Session Continuity

To test session continuity:

1. Make an initial request
2. Wait or simulate a new session with the same MSISDN
3. Verify the resume prompt appears
4. Test resume and restart options

See `tests/Feature/SessionContinuityTest.php` for examples.

## Testing Artisan Commands

```bash
# Test state generation
php artisan ussd:state TestState

# Test action generation
php artisan ussd:action TestAction

# Test flow scaffolding
php artisan ussd:flow TestFlow
```

Verify the generated files are correct.

## Common Testing Scenarios

### 1. Basic Flow Test
- Initial state loads correctly
- User input is processed
- State transitions work
- Session ends properly

### 2. Menu Building Test
- Text rendering
- Option formatting
- Pagination
- Input expectations

### 3. Session Management Test
- Session persistence
- Context data storage
- Session clearing
- Continuity metadata

### 4. Error Handling Test
- Invalid input handling
- Missing state handling
- Session timeout
- Gateway adapter errors

## Continuous Integration

For CI/CD, add to `.github/workflows/tests.yml`:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3
      - uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - run: composer install
      - run: composer test
```

## Troubleshooting

### Tests Fail with "Class not found"
- Run `composer dump-autoload`
- Check namespace matches file location

### Cache Issues
- Clear cache: `php artisan cache:clear`
- Use array cache driver in tests (already configured)

### Session Issues
- Ensure cache driver is set to 'array' in test environment
- Check session repository binding

## Next Steps

After testing:
1. Fix any failing tests
2. Add test coverage for edge cases
3. Update documentation
4. Tag a release version
5. Publish to Packagist

