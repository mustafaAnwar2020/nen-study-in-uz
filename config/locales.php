<?php

return [
    'supported' => ['en', 'ar', 'ru'],

    'rtl' => ['ar'],

    'labels' => [
        'en' => 'EN',
        'ar' => 'AR',
        'ru' => 'RU',
    ],

    /** DB column suffix per locale (English uses the base column). */
    'db_suffix' => [
        'ar' => '_ar',
        'ru' => '_ru',
    ],
];
