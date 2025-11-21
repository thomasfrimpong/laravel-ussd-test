<!-- Copilot instructions for the laravel-ussd package -->

# Quick instructions for AI code contributors

This repository is a Laravel package that implements a state-driven USSD framework
with session-continuity support. The notes below capture the essential architecture,
developer workflows, and repository conventions an automated coding agent should follow.

1. Big-picture / architecture

   - Central orchestrator: `src/Machine/Machine.php` — loads session context, offers
     resume prompts, dispatches `StateEntered`/`StateExited`, and runs state transitions.
   - State contract: `src/Contracts/State.php` and base helper `src/Support/AbstractState.php`.
     States implement `entry(Context): UssdResponse` and `next(Context, string): ?string`.
   - Session persistence: `src/Session/SessionRepositoryInterface.php` with a cache-backed
     implementation at `src/Session/CacheSessionRepository.php`. Continuity metadata is stored
     on the Context (`context->continuity`) and keyed by `ussd:{msisdn}:{sessionId}`.
   - Menu and response: `src/Menu/Menu.php` builds plain-text menus; `src/Support/UssdResponse.php`
     wraps `CON`/`END` semantics.
   - HTTP entry point: `src/Http/Controllers/UssdController.php` — normalizes gateway payloads
     (supports `sessionId`/`session_id`, `msisdn`/`phoneNumber`, `text`) then delegates to Machine.
   - Gateway adapters: `src/Gateways/` contains adapters (e.g., `AfricasTalkingAdapter`, `TwilioAdapter`)
     — follow their request/response normalization patterns.

2. Important files & examples (use these as authoritative examples)

   - Orchestrator: `src/Machine/Machine.php` — see resume flow (`makeResumePrompt`, `handleResumeSelection`).
   - Sessions: `src/Session/CacheSessionRepository.php` — TTL comes from `config('ussd.continuity.timeout')`.
   - State base: `src/Support/AbstractState.php` — use `response($menu)` to return CON/END.
   - Menu API: `src/Menu/Menu.php` — use `text()`, `option()`, `listing()` and `expectsInput()`.
   - Scaffolding: `src/Console/Commands/*` — commands `ussd:state`, `ussd:action`, `ussd:flow` use stubs
     in `src/Console/stubs` or `src/stubs` and rely on config keys `ussd.state_namespace` / `ussd.action_namespace`.

3. Developer workflows (how to run & test)

   - Install deps: run `composer install`.
   - Run tests: `composer test` (invokes `vendor/bin/phpunit`). The repo uses `orchestra/testbench` in dev.
   - PHPUnit settings: see `phpunit.xml.dist` — tests bootstrap `vendor/autoload.php`, and env overrides
     set `CACHE_DRIVER=array` and `SESSION_DRIVER=array` for isolation.
   - Scaffolding examples: run `php artisan ussd:state WelcomeState` or `php artisan ussd:flow MyFlow` inside
     a Laravel app that includes this package as a local dependency.

4. Project-specific conventions & gotchas

   - States must return the fully-qualified class name of the next state (string) or null to end the session.
     Example (inside `next`): return `App\Ussd\States\ConfirmState::class;` or `null`.
   - Use the package `config/ussd.php` keys to discover initial state and namespaces (the generator reads these).
   - Continuity flow: resume prompt is only offered on an initial request with empty input; state continuity
     metadata is under `Context->continuity` (see `Machine::shouldOfferResume`).
   - Cache key format: `ussd:{msisdn}:{sessionId}` — changing this requires updating `CacheSessionRepository`.

5. Integration / extension points

   - To add a gateway: implement `src/Gateways/RequestAdapterInterface.php` and follow existing adapters.
   - To change persistence: implement `SessionRepositoryInterface` and bind in the service provider.
   - Events: `src/Events/*` are dispatched for important lifecycle hooks — tests often assert these events.

6. When editing code (rules for AI changes)

   - Keep public API stable: avoid renaming `Machine::handle`/`handleResumeSelection` or session repo methods.
   - When altering continuity behavior, update both `Machine` and `CacheSessionRepository` and the docs in `docs/session-continuity.md`.
   - Use existing stubs (`src/stubs` and `src/Console/stubs`) when adding generators.

7. Where to look for tests and examples
   - Tests: `tests/` (Feature and Unit examples). `tests/Fixtures/WelcomeState.php` shows a concrete state.
   - Examples: `examples/WelcomeState.php` and `docs/` (getting-started, session-continuity) contain useful usage patterns.

If anything above is unclear or you'd like a different emphasis (more on tests, scaffolding, or gateway adapters), tell me which area to expand and I will iterate.
