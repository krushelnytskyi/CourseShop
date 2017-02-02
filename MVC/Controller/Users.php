<?php

namespace MVC\Controller;

use MVC\Models\Article;
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
        $view = new View('users/login');

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

        if ($form->execute() === false) {
            $view->assign('errors', $form->getErrors());
            return $view;
        }

        $repository = Repository::getInstance();
        $repository->useModel(User::class);

        /** @var User $user */
        $user = $repository->findOneBy(
            [
                'email'    => $form->getFieldValue('email'),
                'password' => User::encodePassword($form->getFieldValue('password'))
            ]
        );

        if ($user !== null) {
            UserSession::getInstance()->setIdentity($user->getId());
            $this->forward('');
        }

        return $view;
    }

    /**
     * Register action
     */
    public function registerAction()
    {
        $view = new View('users/register');

        if (empty($_POST)) {
            return $view;
        }

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
            $view->assign('errors', $form->getErrors());

            return $view;
        }

        $repository = Repository::getInstance();
        $repository->useModel(User::class);

        $user = $repository->findOneBy(
            [
                'email'    => $form->getFieldValue('email'),
            ]
        );

        if ($user === null) {
            $user = new User();
            $user->setNickname($form->getFieldValue('username'));
            $user->setEmail($form->getFieldValue('email'));
            $user->setPassword(User::encodePassword($form->getFieldValue('password')));
            $repository->save($user);
            $this->forward('users/login');
        }

        $view->assign('success', true);

        return $view;
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
        $repo->useModel(User::class);
        $user = $repo->findOneBy(['id' => $id]);

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
        $repo = Repository::getInstance();
        $repo->useModel(Tag::class);

        var_dump($repo->findBy([],2,2,'id'));
    }
}
