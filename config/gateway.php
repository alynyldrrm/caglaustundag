<?php

return [
    'base_url' => env('GATEWAY_BASE_URL', 'https://messagegateway.godeva.com.tr'),

    'timeout' => env('GATEWAY_TIMEOUT', 30),

    'mail' => [
        'default' => env('GATEWAY_MAIL_DEFAULT_DRIVER', 'primary'),

        'drivers' => [
            'primary' => [
                'public_key' => env('GATEWAY_MAIL_PRIMARY_PUBLIC_KEY'),
                'secret_key' => env('GATEWAY_MAIL_PRIMARY_SECRET_KEY'),
            ],

            // Diğer mail driver'larınızı buraya ekleyebilirsiniz
            // 'mailjet' => [
            //     'public_key' => env('GATEWAY_MAIL_MAILJET_PUBLIC_KEY'),
            //     'secret_key' => env('GATEWAY_MAIL_MAILJET_SECRET_KEY'),
            // ],
        ],
    ],

    'sms' => [
        'default' => env('GATEWAY_SMS_DEFAULT_DRIVER', 'netgsm'),

        'drivers' => [
            'netgsm' => [
                'public_key' => env('GATEWAY_SMS_NETGSM_PUBLIC_KEY'),
                'secret_key' => env('GATEWAY_SMS_NETGSM_SECRET_KEY'),
            ],

            'turktelekom' => [
                'public_key' => env('GATEWAY_SMS_TURKTELEKOM_PUBLIC_KEY'),
                'secret_key' => env('GATEWAY_SMS_TURKTELEKOM_SECRET_KEY'),
            ],

            // Diğer SMS driver'larınızı buraya ekleyebilirsiniz
        ],
    ],

    'retry' => [
        'times' => env('GATEWAY_RETRY_TIMES', 3),
        'sleep' => env('GATEWAY_RETRY_SLEEP', 1000), // milliseconds
    ],
];
