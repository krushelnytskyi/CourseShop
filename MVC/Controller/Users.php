<?php

namespace MVC\Controller;

use MVC\Models\Tag;
use MVC\Models\User;
use System\Config;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
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
        $login = $_POST['register_username'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];

        $repo = new Repository(User::class);
        $users = $repo->findBy(
            [
                'email'    => $email,
                'password' => $password
            ]
        );

        if (empty($users) === true) {
            $user = new User();
            $user->setEmail($email);
            // ...

            $repo->save($user);
        }

        $this->view('users/register');
    }


    public function testAction()
    {
        $tag = new Tag();
        $tag->setValue('from ORM');

        $repo = new Repository(Tag::class);
        echo $repo->save($tag);
    }

}
