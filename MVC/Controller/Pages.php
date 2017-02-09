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

    public function editAction()
    {
    }

    public function articleAction()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(,$id) = explode('/', $url);
        $repo = Repository::getInstance();
        $article = $repo->findOneBy(Article::class,['id' => $id]);

        if ($article === null){
            return new View('errors/404');
        } else {
            $view = new View('pages/article');
            $view->assign('article', $article);
            return $view;
        }
    }

    public function articleAddAction()
    {
        $view = new View('pages/articleAdd');

        $view->assign('communities', Repository::getInstance()->findBy(Community::class));

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

    public function communityCreateAction()
    {
        if (Session::getInstance()->hasIdentity()) {
            return new View('pages/communityCreate');
        } else {
            return new View('errors/undefined_user');
        }

    }

    public function jsonCommunityCreateAction()
    {
        $result = [];

        $form = new Form(
            $_POST,
            [
                'name' => [
                    new Strings(2,64),
                ],
                'about' => [
                    new Strings(0,300),
                ]
            ]
        );
        $secured = isset($_POST['secured']) ? true : false;

        if (false === $form->execute()) {
            $result = [
                'messages' => $form->getErrors()
            ];
        } else {
            $community = Repository::getInstance()->findOneBy(
                Community::class,
                [
                    'name'    => $form->getFieldValue('name'),
                ]
            );

            if ($community === null) {
                $community = new Community();
                $community->setName($form->getFieldValue('name'));
                $community->setUser(UserSession::getInstance()->getIdentity());
                $community->setAbout(addslashes($form->getFieldValue('about')));
                $community->setSecured((int)((bool)$secured));

                if (($id = Repository::getInstance()->save($community)) !== false) {
                    $result = [
                        'title' => 'Article',
                        'text' => 'Article add',
                        'redirect' => '/'
                    ];
                } else {
                    $result = [
                        'message' => 'Something gone wrong'
                    ];
                }
            } else {
                $result = [
                    'message' => 'Community exists'
                ];
            }
        }

        $this->json($result);
    }

}