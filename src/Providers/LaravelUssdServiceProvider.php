<?php

namespace Vendor\LaravelUssd\Providers;

use Illuminate\Support\ServiceProvider;
use Vendor\LaravelUssd\Console\Commands\MakeActionCommand;
use Vendor\LaravelUssd\Console\Commands\MakeFlowCommand;
use Vendor\LaravelUssd\Console\Commands\MakeStateCommand;
use Vendor\LaravelUssd\Session\CacheSessionRepository;
use Vendor\LaravelUssd\Session\SessionRepositoryInterface;
use Vendor\LaravelUssd\Http\Middleware\NormalizeUssdRequest;
use function base_path;
use function config_path;

/**
 * Service provider for Laravel USSD package.
 *
 * Registers package services, publishes configuration and stubs,
 * registers Artisan commands, and loads routes and translations.
 */
class LaravelUssdServiceProvider extends ServiceProvider
{
    /**
     * Register package services.
     *
     * Merges configuration and binds session repository implementation.
     *
     * @return void
     */
    public function register(): void
    {
        // Merge package configuration with application config
        $this->mergeConfigFrom(__DIR__ . '/../../config/ussd.php', 'ussd');

        // Bind session repository implementation
        $this->app->bind(SessionRepositoryInterface::class, function ($app) {
            $config = $app['config'];

            return new CacheSessionRepository(
                $app['cache']->store($config->get('ussd.cache_store')),
                $config
            );
        });
    }

    /**
     * Bootstrap package services.
     *
     * Publishes configuration and stubs, registers commands, loads routes
     * and translations, and registers middleware alias.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish configuration file
            $this->publishes([
                __DIR__ . '/../../config/ussd.php' => config_path('ussd.php'),
            ], 'ussd-config');

            // Register Artisan commands
            $this->commands([
                MakeStateCommand::class,
                MakeActionCommand::class,
                MakeFlowCommand::class,
            ]);

            // Publish stub files for code generation
            $this->publishes([
                __DIR__ . '/../../stubs' => base_path('stubs/ussd'),
            ], 'ussd-stubs');
        }

        // Load package routes
        $this->loadRoutesFrom(__DIR__ . '/../../routes/ussd.php');
        // Load package translations
        $this->loadTranslationsFrom(__DIR__ . '/../../resources/lang', 'laravel-ussd');

        // Register middleware alias for request normalization
        $this->app['router']->aliasMiddleware('ussd.normalize', NormalizeUssdRequest::class);
    }
}
