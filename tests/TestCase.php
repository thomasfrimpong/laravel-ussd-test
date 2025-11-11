<?php

namespace Vendor\LaravelUssd\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Vendor\LaravelUssd\Providers\LaravelUssdServiceProvider;

/**
 * Base test case for package tests.
 *
 * Provides common setup and configuration for all package tests.
 */
abstract class TestCase extends OrchestraTestCase
{
    /**
     * Get package providers.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelUssdServiceProvider::class,
        ];
    }

    /**
     * Define environment setup.
     *
     * @param \Illuminate\Foundation\Application $app
     * @return void
     */
    protected function defineEnvironment($app): void
    {
        // Use array cache for testing
        $app['config']->set('cache.default', 'array');
        
        // Set default USSD configuration
        $app['config']->set('ussd.initial_state', \Vendor\LaravelUssd\Tests\Fixtures\WelcomeState::class);
        $app['config']->set('ussd.state_namespace', 'Vendor\\LaravelUssd\\Tests\\Fixtures');
        $app['config']->set('ussd.action_namespace', 'Vendor\\LaravelUssd\\Tests\\Fixtures');
    }
}

