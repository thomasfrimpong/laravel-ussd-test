<?php

/**
 * Simple build script for documentation site
 * This processes Blade templates and generates static HTML
 */

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Compilers\BladeCompiler;

// Create container
$container = new Container();

// Create filesystem
$filesystem = new Filesystem();

// Create event dispatcher
$events = new Dispatcher($container);

// Create view finder
$finder = new FileViewFinder($filesystem, [__DIR__ . '/source']);
$finder->addNamespace('docs', __DIR__ . '/source/docs');

// Create Blade compiler
$compiler = new BladeCompiler($filesystem, __DIR__ . '/build_local/cache');

// Check if PhpEngine needs Filesystem by inspecting its constructor
$phpEngineReflection = new \ReflectionClass(PhpEngine::class);
$phpEngineParams = $phpEngineReflection->getConstructor()->getParameters();
$phpEngineNeedsFilesystem = count($phpEngineParams) > 0;

// Create view factory - try Laravel 11+ approach first, fall back to Laravel 8-10
// Laravel 11+ uses EngineResolver, Laravel 8-10 uses individual engines
$factory = null;

// Try Laravel 11+ approach (EngineResolver)
if (class_exists('Illuminate\View\Engines\EngineResolver')) {
    try {
        // Create PhpEngine instance first to ensure Filesystem is passed
        $phpEngineInstance = new PhpEngine($filesystem);
        $bladeEngineInstance = new CompilerEngine($compiler);
        
        $resolver = new \Illuminate\View\Engines\EngineResolver();
        $resolver->register('blade', function () use ($bladeEngineInstance) {
            return $bladeEngineInstance;
        });
        // In Laravel 11+, PhpEngine always requires Filesystem
        $resolver->register('php', function () use ($phpEngineInstance) {
            return $phpEngineInstance;
        });
        // Laravel 11+ Factory constructor: (EngineResolver, ViewFinderInterface, Dispatcher)
        $factory = new Factory($resolver, $finder, $events);
    } catch (\Throwable $e) {
        // If this fails, try Laravel 8-10 approach
        echo "Laravel 11+ approach failed: " . $e->getMessage() . "\n";
        $factory = null;
    }
}

// Fall back to Laravel 8-10 approach (individual engines)
if ($factory === null) {
    if ($phpEngineNeedsFilesystem) {
        // PhpEngine requires Filesystem (Laravel 9+)
        $phpEngine = new PhpEngine($filesystem);
    } else {
        // PhpEngine doesn't require Filesystem (Laravel 8)
        $phpEngine = new PhpEngine();
    }
    
    $bladeEngine = new CompilerEngine($compiler);
    $factory = new Factory($events, $finder, $phpEngine, $bladeEngine);
}

// Set container instance
Container::setInstance($container);
$container->instance('view', $factory);

// Create build directory
$buildDir = __DIR__ . '/build_local';
if (!is_dir($buildDir)) {
    mkdir($buildDir, 0755, true);
}

// Create assets directory
$assetsDir = $buildDir . '/assets';
if (!is_dir($assetsDir)) {
    mkdir($assetsDir, 0755, true);
}

// Simple route mapping
$routes = [
    '/' => 'index',
    '/docs/installation' => 'installation',
    '/docs/requirements' => 'requirements',
    '/docs/state' => 'state',
    '/docs/menu' => 'menu',
    '/docs/action' => 'action',
    '/docs/session-continuity' => 'session-continuity',
    '/docs/testing' => 'testing',
];

// Determine base path for GitHub Pages
// GitHub Pages uses /repository-name as base path
// Extract from GITHUB_REPOSITORY env var if available, or use default
$githubRepo = getenv('GITHUB_REPOSITORY') ?: '';
if ($githubRepo) {
    // Extract repo name (e.g., "thomasfrimpong/laravel-ussd-test" -> "laravel-ussd-test")
    $repoParts = explode('/', $githubRepo);
    $repoName = end($repoParts);
    $basePath = '/' . $repoName;
} else {
    // Default for this repository
    $basePath = '/laravel-ussd-test';
}

foreach ($routes as $path => $view) {
    try {
        // Use docs namespace for documentation pages, default for index
        $viewName = $path === '/' ? $view : "docs::{$view}";
        $html = $factory->make($viewName, [
            'currentPath' => $path,
            'basePath' => $basePath
        ])->render();
        
        $filePath = $buildDir . $path;
        if ($path === '/') {
            $filePath .= 'index.html';
        } else {
            $filePath .= '/index.html';
        }
        
        $dir = dirname($filePath);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        file_put_contents($filePath, $html);
        echo "Built: {$path}\n";
    } catch (Exception $e) {
        echo "Error building {$path}: " . $e->getMessage() . "\n";
    }
}

// Copy assets (CSS and JS will be built by Vite, but we need to ensure the directory exists)
echo "Build complete!\n";
echo "Note: Run 'npm run build' to build CSS and JS assets.\n";

