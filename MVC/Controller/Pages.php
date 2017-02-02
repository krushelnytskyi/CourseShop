<?php

namespace MVC\Controller;

use MVC\Models\Article;
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
        
        $repository = Repository::getInstance();
        $repository->useModel(Article::class);
        
        $articles = $repository->findBy();

        $view->assign('articles',$articles);

        return $view;
    }

    public function editAction()
    {
    }

    public function articleAction()
    {
//        articles/1

        $this->view('pages/article');
    }

    public function articleAddAction()
    {
        $view = new View('pages/articleAdd');
        if(Session::getInstance()->hasIdentity() === false){
            $view->assign('error','User not register');
        }

        if (empty($_POST)) {
            return $view;
        }

        $form = new Form(
            $_POST,
            [
                'title' => [],
                'body' => [],
                'tags' => [],
            ]
        );

        if ($form->execute() === false){
            $view->assign('errors',$form->getErrors());
        } else {
            $repository = Repository::getInstance();
            $repository->useModel(Article::class);

            $article = new Article();
            $article->setUser(Session::getInstance()->getIdentity());
            $article->setTitle($form->getFieldValue('title'));
            $article->setBody($form->getFieldValue('body'));
            $article->setTags($form->getFieldValue('tags'));
            $article->setRating(0);
            $repository->save($article);
            $this->forward('pages/home');
        }

        return $view;

    }

}