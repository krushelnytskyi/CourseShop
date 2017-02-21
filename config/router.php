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
        'community' => [
            'controller' => \MVC\Controller\Community::class,
            'action'     => 'communities'
        ],
        'article-add' => [
            'controller' => \MVC\Controller\Article::class,
            'action'     => 'create'
        ],
        'admin/users' => [
            'controller' => 'MVC\Controller\Admin',
            'action'     => 'users'
        ],
        'admin/article' => [
            'controller' => 'MVC\Controller\Admin',
            'action'     => 'article'
        ],
        'users/json-register' => [
            'controller' => \MVC\Controller\Users::class,
            'action'     => 'jsonRegister'
        ],
        'users/json-login' => [
            'controller' => \MVC\Controller\Users::class,
            'action'     => 'jsonLogin'
        ],
        'api/comments/new' => [
            'controller' => \MVC\Controller\Api\Comments::class,
            'action'     => 'new'
        ]
    ],
    'patterns' => [
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
        ],
        'tags\/.*' => [
            'controller' => \MVC\Controller\Pages::class,
            'action'     => 'tagSearch'
        ],
        'community\/[0-9]+' => [
            'controller' => \MVC\Controller\Community::class,
            'action'     => 'show'
        ],

    ],
    'defaults' => [
        'not_found' => 'errors/404'
    ]
];