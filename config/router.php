<?php

return [
    'urls' => [
        'users/login' => [
            'controller' => 'MVC\Controller\Users',
            'action'     => 'loginElseAction'
        ]
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