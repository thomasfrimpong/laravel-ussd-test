@extends('_layouts.master')

@section('title', 'Requirements')

@push('styles')
@php
    $base = $basePath ?? '/laravel-ussd-test';
    $base = rtrim($base, '/');
@endphp
<link rel="stylesheet" href="{{ $base }}/assets/app.css">
<script src="{{ $base }}/assets/app.js" defer></script>
@endpush

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>Requirements</h1>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Required</h2>
        <p>Laravel USSD has the following requirements:</p>
        <ul class="mb-0">
            <li><strong>PHP:</strong> ^8.1</li>
            <li><strong>Laravel:</strong> ^8.0|^9.0|^10.0|^11.0|^12.0</li>
            <li><strong>Cache Driver:</strong> Any Laravel-supported cache driver (Redis, Memcached, Database, File, Array)</li>
        </ul>
    </section>

    <section class="bg-white border border-gray-200 rounded-lg p-6 mb-8">
        <h2 class="mt-0">Recommended</h2>
        <ul class="mb-0">
            <li><strong>Redis</strong> or <strong>Memcached</strong> for production environments (better performance for session management)</li>
            <li><strong>PHP 8.2+</strong> for better performance</li>
        </ul>
    </section>
</div>
@endsection

