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
            'controller' => \MVC\Controller\Pages::class,
            'action'     => 'communityCreate'
        ],
        'pages/json-community-create' => [
            'controller' => \MVC\Controller\Pages::class,
            'action'     => 'jsonCommunityCreate'
        ],
        'users/json-register' => [
            'controller' => \MVC\Controller\Users::class,
            'action'     => 'jsonRegister'
        ],
        'users/json-login' => [
            'controller' => \MVC\Controller\Users::class,
            'action'     => 'jsonLogin'
        ],
        'pages/json-add' => [
            'controller' => \MVC\Controller\Pages::class,
            'action'     => 'jsonArticleAdd'
        ]
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
        'article\/[0-9]+' => [
            'controller' => \MVC\Controller\Article::class,
            'action'     => 'show'
        ],
        'article\/[0-9]+\/edit' => [
            'controller' => \MVC\Controller\Article::class,
            'action'     => 'edit'
        ]
    ],
    'defaults' => [
        'not_found' => 'errors/404'
    ]
];