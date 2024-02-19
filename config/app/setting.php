<?php

declare(strict_types=1);

return [
    'otp' => [
        'enable' => (bool) env(key: 'OTP_ENABLE', default: false),
    ],
    'image' => [
        'url' => 'images',
    ],
];
