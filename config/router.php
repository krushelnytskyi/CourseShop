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
        '' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'home'
        ],
        'article/add' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'articleAdd'
        ]
    ],
    'patterns' => [
        '^api\/.+\/(.+)' => [
            'controller' => 'MVC\Controller\Api\Users',
            'action'     => '$1'
        ],
        'article\/[0-9]+' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'article'
        ]
    ],
    'defaults' => [
        'not_found' => 'errors/404'
    ]
];