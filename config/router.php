<?php

return [
    'urls' => [
        'users' => [
            'controller' => 'MVC\Controller\Users',
            'action'     => 'login'
        ],
        'logout' => [
            'controller' => 'MVC\Controller\Users',
            'action'     => 'logout'
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