<?php

namespace MVC\Controller;

use MVC\Models\Tag;
use MVC\Models\User;
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
        $view->assign('email', 'test email');

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
                'register_username' => [
                    new Strings(),
                ],
                'register_email' => [
                    new Email(),
                ],
                'register_password' => [
                    new Strings(),
                ],
                'register_repeat_password' => [
                    new Strings(),
                ],
            ]
        );

        if (false === $form->execute()) {
            $view->assign('errors', $form->getErrors());

            return $view;
        }


        $repository = new Repository(User::class);

        $user = $repository->findBy(
            [
                'email'    => $form->getFieldValue('register_email'),
                'password' => User::encodePassword($form->getFieldValue('register_password'))
            ]
        );

        if (empty($user) === true) {
            $user = new User();
            $user->setNickname($form->getFieldValue('register_username'));
            $user->setEmail($form->getFieldValue('register_email'));
            $user->setPassword(User::encodePassword($form->getFieldValue('register_password')));
            $repository->save($user);

        }


        $view->assign('success', true);

        return $view;

    }


    public function testAction()
    {
        $tag = new Tag();
        $tag->setValue('from ORM');

        $repo = new Repository(Tag::class);
        echo $repo->save($tag);
    }

}
