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
        'admin/users' => [
            'controller' => 'MVC\Controller\Admin',
            'action'     => 'users'
        ],
        'admin/article' => [
            'controller' => 'MVC\Controller\Admin',
            'action'     => 'article'
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
        ],
        'users\/[0-9]+' => [
            'controller' => \MVC\Controller\Users::class,
            'action'     => 'profile'
        ],
        'articles\/[0-9]+' => [
            'controller' => \MVC\Controller\Pages::class,
            'action'     => 'article'
        ]
    ],
    'defaults' => [
        'not_found' => 'errors/404'
    ]
];