# Session Continuity

When a user abandons a USSD flow and dials back within the configured timeout, the package can resume the previous session.

## How It Works

1. Each state entry persists continuity metadata (`state`, `timestamp`, optional payload).
2. On a fresh dial-in with no input, the machine checks if the previous session is still valid.
3. If valid, the user receives a prompt asking to resume or restart.
4. Their selection routes either to the stored state or the initial state.

## Configuration

Update `config/ussd.php`:

```php
'continuity' => [
    'enabled' => true,
    'timeout' => 900,
    'resume_prompt' => 'Pick up where you left off?',
    'resume_option_key' => '1',
    'resume_option_text' => 'Resume previous session',
    'restart_option_key' => '2',
    'restart_option_text' => 'Start over',
],
```

## Custom Prompts

Publish the language files and edit `resources/lang/vendor/laravel-ussd/en/messages.php` to localize resume text.
