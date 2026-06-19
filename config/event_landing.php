<?php

/**
 * Event landing page section types.
 * Each type is stored as one row in event_landing_sections with JSON content.
 */
return [
    'sections' => [
        'hero' => [
            'label' => 'Hero banner',
            'sort_order' => 0,
        ],
        'about_reasons' => [
            'label' => 'About & reasons to join',
            'sort_order' => 10,
        ],
        'stats' => [
            'label' => 'Statistics bar',
            'sort_order' => 20,
        ],
        'details_map' => [
            'label' => 'Event details & map',
            'sort_order' => 30,
        ],
        'speakers' => [
            'label' => 'Meet our speakers',
            'sort_order' => 40,
        ],
        'agenda' => [
            'label' => 'Agenda timeline',
            'sort_order' => 50,
        ],
        'partners' => [
            'label' => 'Organizers & partners',
            'sort_order' => 60,
        ],
        'landing_faq' => [
            'label' => 'Frequently asked questions',
            'sort_order' => 70,
        ],
    ],
];
