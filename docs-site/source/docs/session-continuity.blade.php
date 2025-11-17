@extends('_layouts.master')

@section('title', 'Session Continuity')

@section('body')
<div class="prose prose-lg max-w-none">
    <h1>Session Continuity</h1>

    <p>When a user abandons a USSD flow and dials back within the configured timeout, the package can resume the previous session.</p>

    <h2>How It Works</h2>

    <ol>
        <li>Each state entry persists continuity metadata (<code class="bg-gray-100 px-2 py-1 rounded">state</code>, <code class="bg-gray-100 px-2 py-1 rounded">timestamp</code>, optional payload).</li>
        <li>On a fresh dial-in with no input, the machine checks if the previous session is still valid.</li>
        <li>If valid, the user receives a prompt asking to resume or restart.</li>
        <li>Their selection routes either to the stored state or the initial state.</li>
    </ol>

    <h2>Configuration</h2>

    <p>Update <code class="bg-gray-100 px-2 py-1 rounded">config/ussd.php</code>:</p>

    <div class="bg-gray-900 rounded-lg p-4 overflow-x-auto">
        <pre class="text-white text-sm"><code>'continuity' => [
    'enabled' => true,
    'timeout' => 900,
    'resume_prompt' => 'Pick up where you left off?',
    'resume_option_key' => '1',
    'resume_option_text' => 'Resume previous session',
    'restart_option_key' => '2',
    'restart_option_text' => 'Start over',
],</code></pre>
    </div>

    <h2>Custom Prompts</h2>

    <p>Publish the language files and edit <code class="bg-gray-100 px-2 py-1 rounded">resources/lang/catalysteria/laravel-ussd/en/messages.php</code> to localize resume text.</p>
</div>
@endsection

