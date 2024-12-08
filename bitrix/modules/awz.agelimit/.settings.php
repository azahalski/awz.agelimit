<?php
return [
    'ui.entity-selector' => [
        'value' => [
            'entities' => [
                [
                    'entityId' => 'awzagelimit-user',
                    'provider' => [
                        'moduleId' => 'awz.agelimit',
                        'className' => '\\Awz\\Agelimit\\Access\\EntitySelectors\\User'
                    ],
                ],
                [
                    'entityId' => 'awzagelimit-group',
                    'provider' => [
                        'moduleId' => 'awz.agelimit',
                        'className' => '\\Awz\\Agelimit\\Access\\EntitySelectors\\Group'
                    ],
                ],
            ]
        ],
        'readonly' => true,
    ]
];