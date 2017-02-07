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
        return new View('pages/articleAdd');
    }

    public function articleById()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(,$id) = explode('/', $url);
        $repo = new Repository(Article::class);
        $article = $repo->findOneBy(['id' => $id]);

        if ($article === null){
            return new View('errors/404');
        } else {
            $view = new View('pages/article');
            $view->assign('article', $article);
            return $view;
        }
    }

    public function communityCreateAction()
    {
        $view = new View('pages/communityCreate');
        return $view;
    }

    /**
     * Article Add action
     */
    public function jsonArticleAddAction()
    {
        $result = [];
        if(Session::getInstance()->hasIdentity() == false){
            $result = [
                'messages' => 'User not register'
            ];
        }

        $form = new Form(
            $_POST,
            [
                'title' => [
                    new Strings(3,255),
                ],
                'body' => [
                    new Strings(3,1000),
                ],
                'tags' => [
                    new Strings(3,255),
                ],
            ]
        );

        if ($form->execute() === false){

            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $repository = Repository::getInstance();
            $repository->useModel(Article::class);

            $article = new Article();
            $article->setUser(Session::getInstance()->getIdentity());
            $article->setTitle($form->getFieldValue('title'));
            $article->setBody($form->getFieldValue('body'));
            $article->setTags($form->getFieldValue('tags'));
            $article->setRating(0);

            if ($repository->save($article) !== false) {
                $result = [
                    'redirect' => '/'
                ];
            } else {
                $result = [
                    'messages' => 'Something gone wrong'
                ];
            }
        }

        $this->json($result);
    }

}