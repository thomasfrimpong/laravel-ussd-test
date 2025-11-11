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
        return __DIR__ . '/../../stubs/action.stub';
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
