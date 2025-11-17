# Laravel USSD

Laravel 11 package for building state-driven USSD applications with session continuity.

## Features

- State-oriented flow with fluent menu builder
- Actions for side-effect handling and branching
- Cache-backed session management with continuity resume option
- Machine orchestrator with configurable error and retry handling
- Gateway adapters for common USSD providers
- Artisan tooling for scaffolding states and actions
- Comprehensive testing utilities and documentation

## Getting Started

1. Install via Composer:
   ```bash
   composer require catalysteria/laravel-ussd
   ```
2. Publish configuration:
   ```bash
   php artisan vendor:publish --provider="Vendor\\LaravelUssd\\Providers\\LaravelUssdServiceProvider"
   ```
3. Scaffold your first state:
   ```bash
   php artisan ussd:state WelcomeState
   ```

See `docs/` for detailed usage, or visit the [online documentation](https://your-username.github.io/laravel-ussd-test/) (once deployed).

## Development

### Auto-Update Packagist

To automatically update Packagist when you push changes, see [Packagist Webhook Setup Guide](docs/packagist-webhook-setup.md).

Quick setup options:
- **GitHub Webhook** (Recommended): Configure webhook in GitHub repository settings
- **GitHub Actions**: Uses the workflow in `.github/workflows/packagist-update.yml`
- **Manual Script**: Run `scripts/update-packagist.sh` or `scripts/update-packagist.bat`