@extends('_layouts.master')

@section('title', 'Menu')

@section('body')
<div class="prose prose-lg max-w-none">
    <div class="mb-8">
        <h1 class="text-5xl font-extrabold bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 bg-clip-text text-transparent mb-4">
            Menu
        </h1>
        <p class="text-xl text-slate-600 leading-relaxed">The Menu class provides a fluent interface for building USSD menus and responses.</p>
    </div>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Basic Usage
        </h2>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">protected function buildMenu(Context $context): Menu
{
    return (new Menu())
        ->text('Welcome!')
        ->option('1', 'Option 1')
        ->option('2', 'Option 2')
        ->expectsInput();
}</code></pre>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-6 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Menu Methods
        </h2>
        <div class="grid md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">text($text)</h3>
                <p class="text-slate-700 mb-0">Sets the main text content of the menu.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">option($key, $label)</h3>
                <p class="text-slate-700 mb-0">Adds a numbered option to the menu. The key is what the user will input, and the label is the display text.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">listing(array $items)</h3>
                <p class="text-slate-700 mb-0">Adds a numbered listing of items, automatically numbering them starting from 1.</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">expectsInput()</h3>
                <p class="text-slate-700 mb-0">Indicates that the menu expects user input (CON response).</p>
            </div>

            <div class="bg-gradient-to-br from-primary-50 to-primary-100/50 rounded-xl p-6 border border-primary-200/50">
                <h3 class="text-xl font-bold text-slate-900 mb-2">paginate(array $items, int $perPage, int $page)</h3>
                <p class="text-slate-700 mb-0">Adds a paginated listing of items with automatic "More" option if there are additional pages.</p>
            </div>
        </div>
    </section>

    <section class="bg-white/80 backdrop-blur-sm border border-slate-200/60 rounded-2xl p-8 mb-8 shadow-lg shadow-slate-200/50 hover:shadow-xl hover:shadow-slate-300/50 transition-all duration-300">
        <h2 class="text-3xl font-bold text-slate-900 mb-4 mt-0 flex items-center">
            <span class="w-1 h-8 bg-gradient-to-b from-primary-500 to-primary-600 rounded-full mr-4"></span>
            Example
        </h2>
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 rounded-xl p-5 overflow-x-auto my-4 shadow-xl border border-slate-700/50">
            <pre class="text-slate-100 text-sm font-mono leading-relaxed"><code class="text-slate-100">protected function buildMenu(Context $context): Menu
{
    return (new Menu())
        ->text('Select an option:')
        ->option('1', 'Check Balance')
        ->option('2', 'Transfer Funds')
        ->option('3', 'View History')
        ->expectsInput();
}</code></pre>
        </div>
    </section>
</div>
@endsection
