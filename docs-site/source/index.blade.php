@extends('_layouts.master')

@section('title', 'Home')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="text-center mb-12">
        <h1 class="text-5xl font-bold text-gray-900 mb-4">Laravel USSD</h1>
        <p class="text-xl text-gray-600">Build state-driven USSD applications with Laravel</p>
    </div>

    <div class="grid md:grid-cols-2 gap-6 mb-12">
        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h2 class="text-2xl font-semibold mb-3">Getting Started</h2>
            <p class="text-gray-600 mb-4">Learn how to install and configure Laravel USSD in your project.</p>
            @php
                $base = $basePath ?? '/laravel-ussd-test';
                $base = rtrim($base, '/');
            @endphp
            <a href="{{ $base }}/docs/installation" class="text-primary-600 hover:text-primary-700 font-medium">Get Started →</a>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
            <h2 class="text-2xl font-semibold mb-3">Core Concepts</h2>
            <p class="text-gray-600 mb-4">Understand states, menus, actions, and session management.</p>
            <a href="{{ $base }}/docs/state" class="text-primary-600 hover:text-primary-700 font-medium">Learn More →</a>
        </div>
    </div>

    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200">
        <h2 class="text-3xl font-semibold mb-4">Features</h2>
        <ul class="space-y-3 text-gray-700">
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>State-oriented flow</strong> with fluent menu builder</span>
            </li>
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>Actions</strong> for side-effect handling and branching</span>
            </li>
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>Cache-backed session management</strong> with continuity resume option</span>
            </li>
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>Machine orchestrator</strong> with configurable error and retry handling</span>
            </li>
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>Gateway adapters</strong> for common USSD providers</span>
            </li>
            <li class="flex items-start">
                <svg class="w-6 h-6 text-primary-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span><strong>Artisan tooling</strong> for scaffolding states and actions</span>
            </li>
        </ul>
    </div>
</div>
@endsection

