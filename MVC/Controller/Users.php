<?php

namespace MVC\Controller;

use MVC\Models\Article;
use MVC\Models\Notifications;
use MVC\Models\Tag;
use MVC\Models\User;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Email;
use System\Validators\Strings;
use System\View;

/**
 * Class Users
 * @package MVC\Controller
 */
class Users extends Controller
{

    /**
     * @action users/login
     */
    public function loginAction()
    {
        return new View('pages/home');
    }

    /**
     * Register action
     */
    public function registerAction()
    {
        return new View('pages/home');
    }

    public function jsonLoginAction()
    {
        $result = [];

        $form = new Form(
            $_POST,
            [
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(1,6),
                ]
            ]
        );

        if (false === $form->execute()) {
            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $repository = Repository::getInstance();
            $user = $repository->findOneBy(User::class,
                [
                    'email'    => $form->getFieldValue('email'),
                    'password' => User::encodePassword($form->getFieldValue('password'))
                ]
            );

            if ($user !== null) {
                UserSession::getInstance()->setIdentity($user->getId());
                $result = [
                    'title' => 'login',
                    'text' => 'Sign in',
                    'redirect' => '/'
                ];
            } else {
                $result = [
                    'message' => 'Something gone wrong'
                ];
            }
        }

        $this->json($result);

    }

    public function jsonRegisterAction()
    {
        $result = [];

        $form = new Form(
            $_POST,
            [
                'username' => [
                    new Strings(8,64),
                ],
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(1,6),
                ],
                'repeat_password' => [
                    new Strings(1,6),
                ],
            ]
        );

        if (false === $form->execute()) {
            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $repository = Repository::getInstance();
            $user = $repository->findOneBy(User::class,
                [
                    'email'    => $form->getFieldValue('email'),
                ]
            );

            if ($user === null) {
                $user = new User();
                $user->setNickname($form->getFieldValue('username'));
                $user->setEmail($form->getFieldValue('email'));
                $user->setPassword(User::encodePassword($form->getFieldValue('password')));

                if (($id = $repository->save($user)) !== false) {
                    UserSession::getInstance()->setIdentity($id);
                    $result = [

                        'title' => 'register',
                        'text' => 'Registration is completed',
                        'redirect' => '/'
                    ];
                } else {
                    $result = [
                        'message' => 'Something gone wrong'
                    ];
                }
            } else {
                $result = [
                    'message' => 'User exists'
                ];
            }
        }
        $this->json($result);
    }

    /**
     * Logout action
     */
    public function logoutAction()
    {
        UserSession::getInstance()->clearIdentity();
        $this->forward('users/login');
    }

    /**
     * User Settings action
     */
    public function settingsAction()
    {
    }

    /**
     * User profile action
     */
    public function profileAction()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(,$id) = explode('/', $url);
        $repo = Repository::getInstance();
        $user = $repo->findOneBy(User::class,['id' => $id]);
        if ($user === null) {
            return new View('errors/404');
        } else {
            $view = new View('users/profile');
            $view->assign('user', $user);
            return $view;
        }
    }

    public function testAction()
    {
    }
}