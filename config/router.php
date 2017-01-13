<?php

return [
    'urls' => [
        'users' => [
            'controller' => 'MVC\Controller\Users',
            'action'     => 'login'
        ],
        'users2' => [
            'controller' => 'MVC\Controller\Users',
            'action'     => 'login'
        ],
    ],
    'patterns' => [
        '^api\/.+\/(.+)' => [
            'controller' => 'MVC\Controller\Api\Users',
            'action'     => '$1'
        ]
    ],
    'defaults' => [
        'not_found' => 'errors/404'
    ]
];