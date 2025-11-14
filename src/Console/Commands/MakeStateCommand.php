<?php

namespace Vendor\LaravelUssd\Console\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * Artisan command to generate USSD state classes.
 *
 * Creates a new state class extending AbstractState with a basic
 * menu structure and next() method stub.
 */
class MakeStateCommand extends GeneratorCommand
{
    /**
     * @var string Command name
     */
    protected $name = 'ussd:state';

    /**
     * @var string Command description
     */
    protected $description = 'Create a new USSD state class';

    /**
     * @var string Type of class being generated
     */
    protected $type = 'State';

    /**
     * Get the stub file for the generator.
     *
     * @return string Path to stub file
     */
    protected function getStub(): string
    {
        // Go up two levels from src/Console/Commands/ to src/, then to stubs/
        $stubPath = realpath(__DIR__ . '/../../stubs/state.stub');
        if ($stubPath === false) {
            // Fallback: construct path manually (go up two directories)
            $stubPath = dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'state.stub';
        }
        return $stubPath;
    }

    /**
     * Get the default namespace for the class.
     *
     * Uses configured state namespace or falls back to App\Ussd\States.
     *
     * @param string $rootNamespace Root namespace
     * @return string Default namespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return config('ussd.state_namespace', $rootNamespace . '\\Ussd\\States');
    }
}
