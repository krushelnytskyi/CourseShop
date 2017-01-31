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
        
        $repository = new Repository(Article::class);
        
        $articles = $repository->findBy();

        $view->assign('articles',$articles);

        return $view;
    }

    public function articleAction()
    {
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
            $_POST
              //TO DO implement validation attribute
        );

        if ($form->execute() === false){
            $view->assign('errors',$form->getErrors());
            return $view;
        }

        $repository = new Repository(Article::class);

        $article = $repository->findOneBy(
            [
                'title' => $form->getFieldValue('Title')
            ]
        );

        if ($article === null){
            $article = new Article();
            $article->setUser(Session::getInstance()->getIdentity());
            $article->setTitle($form->getFieldValue('Title'));
            $article->setBody($form->getFieldValue('Text'));
            $article->setTags($form->getFieldValue('Tags'));
            $repository->save($article);
            $this->forward('pages/home');
        }
        return $view;

    }

}