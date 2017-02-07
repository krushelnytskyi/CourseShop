<?php

namespace MVC\Controller;

use MVC\Models\Article;
use MVC\Models\User;
use System\Database\Connection;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\View;


/**
 * Class Admin
 * @package MVC\Controller\
 */
class Admin extends Controller
{

    /**
     * @return View
     */
    public function usersAction()
    {
        $repository = Repository::getInstance();
        $users = $repository->findBy(User::class);
        $view = new View('admin/users');
        $view->assign('users', $users);
        return $view;

    }

    /**
     * @return View
     */
    public function articleAction()
    {
        $repository = Repository::getInstance();
        $article = $repository->findBy(Article::class);
        $view = new View('admin/article');
        $view->assign('article',$article);
        return $view;

    }

}