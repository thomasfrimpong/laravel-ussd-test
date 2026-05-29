# Session Continuity

A USSD session can end before the flow is complete: the user presses cancel, the
session times out at the gateway, or the application crashes. In all of these
cases the gateway issues a **new session ID** the next time the user dials in.
When this happens within the configured timeout, the package offers the user a
choice to resume the previous session or start over from the beginning.

## How It Works

1. Each state entry persists continuity metadata (`state`, `timestamp`, optional
   payload) and, crucially, an **MSISDN-level snapshot** that also stores the
   data collected so far. This snapshot is keyed only by phone number
   (`ussd:continuity:{msisdn}`), independent of the session ID.
2. On a fresh dial-in with no input, the machine cannot find a record for the new
   session ID, so it falls back to the MSISDN snapshot to detect unfinished
   progress and checks that it is still valid (within `timeout`).
3. If valid, the user receives a prompt asking to resume or restart.
4. Their selection routes either to the stored state (with previously collected
   data restored) or the initial state (with data cleared).

Because the snapshot is keyed by phone number rather than session ID, resume
works across the cancel, timeout, and crash scenarios above. The snapshot is
removed when a session completes normally or when the user chooses "Start over",
so finished flows are never offered for resume.

## Configuration

Update `config/ussd.php`:

```php
'continuity' => [
    'enabled' => true,
    'timeout' => 900,
    'resume_min_age' => 30, // Only offer resume if the last activity was at least this many seconds ago
    'resume_prompt' => 'Pick up where you left off?',
    'resume_option_key' => '1',
    'resume_option_text' => 'Resume previous session',
    'restart_option_key' => '2',
    'restart_option_text' => 'Start over',
],
```

## Custom Prompts

Publish the language files and edit `resources/lang/catalysteria/laravel-ussd/en/messages.php` to localize resume text.
