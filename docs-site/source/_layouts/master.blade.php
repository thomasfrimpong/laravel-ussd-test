<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Laravel USSD') - Laravel USSD Documentation</title>
    <meta name="description" content="@yield('description', 'Documentation for Laravel USSD package')">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        }
                    }
                }
            }
        }
    </script>
    @php
        $base = $basePath ?? '/laravel-ussd-test';
        $base = rtrim($base, '/');
    @endphp
    <link rel="stylesheet" href="{{ $base }}/assets/app.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .prose { color: #374151; }
        .prose h1 { color: #111827; font-weight: 800; }
        .prose h2 { color: #1f2937; font-weight: 700; }
        .prose h3 { color: #374151; font-weight: 600; }
        .prose code { background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 0.25rem; font-size: 0.875em; }
        .prose pre { background: #1e293b; }
        .prose pre code { background: transparent; padding: 0; }
    </style>
    <base href="{{ $base }}/">
</head>
<body class="bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white/80 backdrop-blur-lg border-b border-slate-200/60 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center shadow-lg shadow-primary-500/20">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                            </svg>
                        </div>
                        <a href="{{ $base }}/" class="text-2xl font-bold bg-gradient-to-r from-primary-600 to-primary-800 bg-clip-text text-transparent hover:from-primary-700 hover:to-primary-900 transition-all">
                            Laravel USSD
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="search-toggle" class="p-2.5 text-slate-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-all duration-200">
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
            <aside class="hidden lg:block w-72 bg-white/60 backdrop-blur-sm border-r border-slate-200/60 overflow-y-auto sticky top-16 h-[calc(100vh-4rem)]">
                <nav class="p-6 space-y-6">
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 px-3">Getting Started</div>
                        <div class="space-y-1">
                            <a href="{{ $base }}/docs/installation" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/installation' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Installation
                            </a>
                            <a href="{{ $base }}/docs/requirements" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/requirements' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Requirements
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 px-3">Core Concepts</div>
                    <div class="space-y-1">
                            <a href="{{ $base }}/docs/state" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/state' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                State
                            </a>
                            <a href="{{ $base }}/docs/menu" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/menu' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                                </svg>
                                Menu
                            </a>
                            <a href="{{ $base }}/docs/action" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/action' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Action
                            </a>
                            <a href="{{ $base }}/docs/decision" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/decision' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                                </svg>
                                Decision
                            </a>
                            <a href="{{ $base }}/docs/record" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/record' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Record
                            </a>
                            <a href="{{ $base }}/docs/machine" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/machine' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Machine
                            </a>
                            <a href="{{ $base }}/docs/session-continuity" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/session-continuity' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Session Continuity
                            </a>
                            <a href="{{ $base }}/docs/testing" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/testing' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Testing
                            </a>
                        </div>
                    </div>
                    
                    <div>
                        <div class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 px-3 mt-6">Examples</div>
                        <div class="space-y-1">
                            <a href="{{ $base }}/docs/example" class="flex items-center px-3 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 {{ isset($currentPath) && $currentPath === '/docs/example' ? 'bg-gradient-to-r from-primary-500 to-primary-600 text-white shadow-lg shadow-primary-500/30' : 'text-slate-700 hover:bg-primary-50 hover:text-primary-600' }}">
                                <svg class="w-4 h-4 mr-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                Complete Example
                            </a>
                        </div>
                    </div>
                </nav>
            </aside>

            <!-- Main Content -->
            <main class="flex-1 overflow-y-auto">
                <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                    @yield('body')
                </div>
            </main>
        </div>

        <!-- Footer -->
        <footer class="bg-white/60 backdrop-blur-sm border-t border-slate-200/60 py-8 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <p class="text-sm text-slate-600">
                    &copy; {{ date('Y') }} Laravel USSD. Built with <span class="text-primary-600 font-medium">Tailwind CSS</span>.
                </p>
            </div>
        </footer>
    </div>

    <!-- Search Modal -->
    <div id="search-modal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full p-6 transform transition-all">
            <input type="text" id="search-input" placeholder="Search documentation..." class="w-full px-4 py-3 border-2 border-slate-200 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition-all text-slate-700">
            <div id="search-results" class="mt-4 max-h-96 overflow-y-auto"></div>
        </div>
    </div>

    <script>
        // Search modal toggle
        document.getElementById('search-toggle')?.addEventListener('click', () => {
            const modal = document.getElementById('search-modal');
            modal.classList.toggle('hidden');
            if (!modal.classList.contains('hidden')) {
                document.getElementById('search-input')?.focus();
            }
        });

        // Close modal on outside click
        document.getElementById('search-modal')?.addEventListener('click', (e) => {
            if (e.target.id === 'search-modal') {
                document.getElementById('search-modal')?.classList.add('hidden');
            }
        });
    </script>
    <script src="{{ $base }}/assets/app.js"></script>
</body>
</html>
