<?php

return [
    'recipient_email' => env('CONTACT_RECIPIENT_EMAIL', env('MAIL_FROM_ADDRESS', 'hello@example.com')),
    'rate_limit' => [
        'per_minute' => (int) env('CONTACT_RATE_LIMIT_PER_MINUTE', 5),
    ],
];
