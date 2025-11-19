@extends('_layouts.master')

@section('title', 'Session Continuity')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Session Continuity
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">When a user abandons a USSD flow and dials back within the configured timeout, the package can resume the previous session.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            How It Works
        </h2>
        <ol class="space-y-3 text-slate-700 mb-0 list-decimal list-inside">
            <li>Each state entry persists continuity metadata (<code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">state</code>, <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">timestamp</code>, optional payload).</li>
            <li>On a fresh dial-in with no input, the machine checks if the previous session is still valid.</li>
            <li>If valid, the user receives a prompt asking to resume or restart.</li>
            <li>Their selection routes either to the stored state or the initial state.</li>
        </ol>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Configuration
        </h2>
        <p class="text-slate-700 mb-4">Update <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">config/ussd.php</code>:</p>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">'continuity' => [
    'enabled' => true,
    'timeout' => 900,
    'resume_prompt' => 'Pick up where you left off?',
    'resume_option_key' => '1',
    'resume_option_text' => 'Resume previous session',
    'restart_option_key' => '2',
    'restart_option_text' => 'Start over',
],</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Custom Prompts
        </h2>
        <p class="text-slate-700 mb-0">Publish the language files and edit <code class="bg-slate-100 px-2 py-1 rounded-md text-slate-800 font-mono text-sm border border-slate-200">resources/lang/catalysteria/laravel-ussd/en/messages.php</code> to localize resume text.</p>
    </section>
</div>
@endsection
