@extends('_layouts.master')

@section('title', 'Home')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="text-center mb-16">
        <h1 class="text-6xl font-extrabold bg-gradient-to-r from-slate-900 via-primary-600 to-slate-900 bg-clip-text text-transparent mb-6">
            Laravel USSD
        </h1>
        <p class="text-2xl text-slate-600 font-medium">Build state-driven USSD applications with Laravel</p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300 group">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Getting Started</h2>
            <p class="text-slate-600 mb-6">Learn how to install and configure Laravel USSD in your project.</p>
            @php
                $base = $basePath ?? '/laravel-ussd-test';
                $base = rtrim($base, '/');
            @endphp
            <a href="{{ $base }}/docs/installation" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group-hover:translate-x-1 transition-transform">
                Get Started 
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300 group">
            <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-600 rounded-xl flex items-center justify-center mb-4 shadow-lg shadow-primary-500/20 group-hover:scale-110 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900 mb-3">Core Concepts</h2>
            <p class="text-slate-600 mb-6">Understand states, menus, actions, and session management.</p>
            <a href="{{ $base }}/docs/state" class="inline-flex items-center text-primary-600 hover:text-primary-700 font-semibold group-hover:translate-x-1 transition-transform">
                Learn More 
                <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                </svg>
            </a>
        </div>
    </div>

    <div class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-10 shadow-lg shadow-slate-200/50">
        <h2 class="text-4xl font-bold text-slate-900 mb-8 flex items-center">
            <span class="w-1 h-10 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Features
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">State-oriented flow</h3>
                    <p class="text-slate-600 text-sm">with fluent menu builder</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">Actions</h3>
                    <p class="text-slate-600 text-sm">for side-effect handling and branching</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">Cache-backed session management</h3>
                    <p class="text-slate-600 text-sm">with continuity resume option</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">Machine orchestrator</h3>
                    <p class="text-slate-600 text-sm">with configurable error and retry handling</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">Gateway adapters</h3>
                    <p class="text-slate-600 text-sm">for common USSD providers</p>
                </div>
            </div>

            <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-primary-50/50 transition-colors">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-600 rounded-lg flex items-center justify-center flex-shrink-0 shadow-lg shadow-primary-500/20">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900 mb-1">Artisan tooling</h3>
                    <p class="text-slate-600 text-sm">for scaffolding states and actions</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
