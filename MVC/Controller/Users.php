<?php

namespace MVC\Controller;

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
        $view = new View('pages/home');

        $form = new Form(
            $_POST,
            [
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(),
                ]
            ]
        );

        if ($form->execute() === false) {
            $view->assign('errors', $form->getErrors());
            return $view;
        }

        $repository = new Repository(User::class);

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
        $view = new View('pages/home');

        if (empty($_POST)) {
            return $view;
        }

        $form = new Form(
            $_POST,
            [
                'username' => [
                    new Strings(),
                ],
                'email' => [
                    new Email(),
                ],
                'password' => [
                    new Strings(),
                ],
                'repeat_password' => [
                    new Strings(),
                ],
            ]
        );

        if (false === $form->execute()) {
            $view->assign('errors', $form->getErrors());

            return $view;
        }

        $repository = new Repository(User::class);

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

}
