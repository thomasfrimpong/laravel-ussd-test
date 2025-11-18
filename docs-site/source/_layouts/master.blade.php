<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel USSD') - Laravel USSD Documentation</title>
    <meta name="description" content="@yield('description', 'Documentation for Laravel USSD package')">
    @php
        // Use base path for GitHub Pages
        $base = $basePath ?? '/laravel-ussd-test';
        $base = rtrim($base, '/');
    @endphp
    <base href="{{ $base }}/">
    <link rel="stylesheet" href="assets/app.css">
    <script src="assets/app.js" defer></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <a href="/" class="text-2xl font-bold text-primary-600 {{ isset($currentPath) && $currentPath === '/' ? '' : '' }}">Laravel USSD</a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="search-toggle" class="p-2 text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 flex">
            <!-- Sidebar -->
            <aside class="hidden lg:block w-64 bg-white border-r border-gray-200 overflow-y-auto sticky top-16 h-[calc(100vh-4rem)]">
                <nav class="p-4">
                    <div class="space-y-1">
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Getting Started</div>
                        <a href="docs/installation" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/installation' ? 'bg-gray-100 font-medium' : '' }}">Installation</a>
                        <a href="docs/requirements" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/requirements' ? 'bg-gray-100 font-medium' : '' }}">Requirements</a>
                        
                        <div class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2 mt-4">Core Concepts</div>
                        <a href="docs/state" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/state' ? 'bg-gray-100 font-medium' : '' }}">State</a>
                        <a href="docs/menu" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/menu' ? 'bg-gray-100 font-medium' : '' }}">Menu</a>
                        <a href="docs/action" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/action' ? 'bg-gray-100 font-medium' : '' }}">Action</a>
                        <a href="docs/session-continuity" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/session-continuity' ? 'bg-gray-100 font-medium' : '' }}">Session Continuity</a>
                        <a href="docs/testing" class="block px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded {{ isset($currentPath) && $currentPath === '/docs/testing' ? 'bg-gray-100 font-medium' : '' }}">Testing</a>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    @yield('body')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 py-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                <p>&copy; {{ date('Y') }} Laravel USSD. Built with Tailwind CSS.</p>
            </div>
        </footer>
    </div>

    <!-- Search Modal -->
    <div id="search-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full p-6">
                <input type="text" id="search-input" placeholder="Search documentation..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                <div id="search-results" class="mt-4"></div>
            </div>
        </div>
    </div>
</body>
</html>

