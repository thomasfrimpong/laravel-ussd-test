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

// Create view factory
$factory = new Factory(
    $events,
    $finder,
    new PhpEngine($filesystem),
    new CompilerEngine($compiler)
);

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

foreach ($routes as $path => $view) {
    try {
        // Use docs namespace for documentation pages, default for index
        $viewName = $path === '/' ? $view : "docs::{$view}";
        $html = $factory->make($viewName, ['currentPath' => $path])->render();
        
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

