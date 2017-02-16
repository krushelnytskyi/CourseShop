<?php

namespace MVC\Controller;

use MVC\Models\Article;
use MVC\Models\Community;
use MVC\Models\User;
use System\Auth\Session;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Strings;
use System\View;

/**
 * Class Pages
 * @package MVC\Controller
 */
class Pages extends Controller
{

    /**
     * @action page
     */
    public function homeAction()
    {
        $view = new View('pages/home');
        
        $articles = Repository::getInstance()
            ->findBy(Article::class);

        $view = new View('pages/home');
        $view->assign('articles', $articles);
        return $view;
    }

}