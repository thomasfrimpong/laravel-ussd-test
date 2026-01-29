<?php

return [
    'initial_state' => 'App\\Ussd\\States\\WelcomeState',

    'state_namespace' => 'App\\Ussd\\States',

    'action_namespace' => 'App\\Ussd\\Actions',

    'cache_store' => env('USSD_CACHE_STORE', null),

    'default_response_suffix' => '',

    'error_state' => null,

    'max_retries' => 3,

    'continuity' => [
        'enabled' => true,
        'timeout' => 900,
        'resume_min_age' => 30, // Only offer resume if last activity was at least this many seconds ago (avoids showing continuity when gateway sends empty input for "0")
        'resume_prompt' => 'We noticed you have an unfinished session. Choose an option:',
        'resume_option_key' => '1',
        'resume_option_text' => 'Resume previous session',
        'restart_option_key' => '2',
        'restart_option_text' => 'Start over',
    ],
];
