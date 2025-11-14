<?php

namespace Vendor\LaravelUssd\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use function app_path;

/**
 * Artisan command to scaffold a complete USSD flow.
 *
 * Generates both a state and action class for a given flow name,
 * creating the necessary directories if they don't exist.
 */
class MakeFlowCommand extends Command
{
    /**
     * @var string Command signature
     */
    protected $signature = 'ussd:flow {name : The flow name}';

    /**
     * @var string Command description
     */
    protected $description = 'Scaffold a starter USSD flow with controller and routes';

    /**
     * Create a new command instance.
     *
     * @param Filesystem $files Filesystem instance for file operations
     */
    public function __construct(protected Filesystem $files)
    {
        parent::__construct();
    }

    /**
     * Execute the command.
     *
     * Creates state and action classes based on the provided flow name.
     *
     * @return int Command exit code
     */
    public function handle(): int
    {
        // Convert flow name to StudlyCase
        $name = Str::studly($this->argument('name'));
        $statePath = app_path('Ussd/States/' . $name . 'State.php');
        $actionPath = app_path('Ussd/Actions/' . $name . 'Action.php');

        // Create directories if they don't exist
        if (!$this->files->isDirectory(dirname($statePath))) {
            $this->files->makeDirectory(dirname($statePath), 0755, true);
        }

        if (!$this->files->isDirectory(dirname($actionPath))) {
            $this->files->makeDirectory(dirname($actionPath), 0755, true);
        }

        // Load and customize stub files
        $stateStubPath = realpath(__DIR__ . '/../stubs/state.stub') ?: dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'state.stub';
        $actionStubPath = realpath(__DIR__ . '/../stubs/action.stub') ?: dirname(__DIR__) . DIRECTORY_SEPARATOR . 'stubs' . DIRECTORY_SEPARATOR . 'action.stub';
        
        $stateStub = str_replace('DummyState', $name . 'State', $this->files->get($stateStubPath));
        $actionStub = str_replace('DummyAction', $name . 'Action', $this->files->get($actionStubPath));

        // Write generated files
        $this->files->put($statePath, $stateStub);
        $this->files->put($actionPath, $actionStub);

        $this->info('Flow scaffolded successfully.');

        return static::SUCCESS;
    }
}
