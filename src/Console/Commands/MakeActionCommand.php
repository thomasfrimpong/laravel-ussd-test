<?php

namespace Vendor\LaravelUssd\Console\Commands;

use Illuminate\Console\GeneratorCommand;

/**
 * Artisan command to generate USSD action classes.
 *
 * Creates a new action class extending AbstractAction with a basic
 * handle() method stub.
 */
class MakeActionCommand extends GeneratorCommand
{
    /**
     * @var string Command name
     */
    protected $name = 'ussd:action';

    /**
     * @var string Command description
     */
    protected $description = 'Create a new USSD action class';

    /**
     * @var string Type of class being generated
     */
    protected $type = 'Action';

    /**
     * Get the stub file for the generator.
     *
     * @return string Path to stub file
     */
    protected function getStub(): string
    {
        // Laravel's GeneratorCommand resolves stubs relative to Console directory
        // So from src/Console/Commands/, we go up one level to src/Console/, then to stubs/
        $stubPath = realpath(__DIR__ . '/../stubs/action.stub');
        if ($stubPath === false) {
            // Fallback: construct path manually (go up one directory to Console, then to stubs)
            $stubPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'action.stub';
        }
        return $stubPath;
    }

    /**
     * Get the default namespace for the class.
     *
     * Uses configured action namespace or falls back to App\Ussd\Actions.
     *
     * @param string $rootNamespace Root namespace
     * @return string Default namespace
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return config('ussd.action_namespace', $rootNamespace . '\\Ussd\\Actions');
    }
}
