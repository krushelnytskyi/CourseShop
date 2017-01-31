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
        'article' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'article'
        ],
        'article-add' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'articleAdd'
        ],
        'community-create' => [
            'controller' => 'MVC\Controller\Pages',
            'action'     => 'communityCreate'
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