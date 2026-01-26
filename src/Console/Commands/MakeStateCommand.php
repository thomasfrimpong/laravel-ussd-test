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
        // Laravel's GeneratorCommand resolves stubs relative to Console directory
        // So from src/Console/Commands/, we go up one level to src/Console/, then to stubs/
        $stubPath = realpath(__DIR__ . '/../stubs/state.stub');
        if ($stubPath === false) {
            // Fallback: construct path manually (go up one directory to Console, then to stubs)
            $stubPath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'state.stub';
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

    /**
     * Build the class with the given name.
     *
     * @param string $name
     * @return string
     */
    protected function buildClass($name)
    {
        $stub = $this->files->get($this->getStub());
        
        // Get the namespace without the class name
        $qualifiedClass = $this->qualifyClass($name);
        $namespace = trim(implode('\\', array_slice(explode('\\', $qualifiedClass), 0, -1)), '\\');
        
        // Replace namespace and class placeholders
        $stub = str_replace(
            ['DummyNamespace', 'DummyState'],
            [$namespace, class_basename($name)],
            $stub
        );

        return $stub;
    }
}
