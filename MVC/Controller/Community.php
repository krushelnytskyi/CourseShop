<?php

namespace MVC\Controller;


use System\Auth\Session;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Strings;
use System\View;

class Community extends Controller
{
    public function communitiesAction()
    {
        $repo = Repository::getInstance();
        $community = $repo->findBy(\MVC\Models\Community::class);

        if ($community === null){
            return new View('errors/404');
        } else {
            $view = new View('community/list');
            $view->assign('communities' , $community);
            return $view;
        }
    }

    public function createAction()
    {
        if (Session::getInstance()->hasIdentity()) {
            return new View('community/create');
        } else {
            return new View('errors/undefined_user');
        }
    }

    public function newAction()
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
                \MVC\Models\Community::class,
                [
                    'name'    => $form->getFieldValue('name'),
                ]
            );

            if ($community === null) {
                $community = new \MVC\Models\Community();
                $community->setName($form->getFieldValue('name'));
                $community->setUser(UserSession::getInstance()->getIdentity());
                $community->setAbout($form->getFieldValue('about'));
                $community->setSecured((int)((bool)$secured));

                if (($id = Repository::getInstance()->save($community)) !== false) {
                    $result['redirect'] = '/';
                } else {
                    $result['message'] = 'Something gone wrong';
                }
            } else {
                $result['message'] = 'Community exists';
            }
        }

        $this->json($result);
    }

    public function showAction()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(,$id) = explode('/', $url);
        $repo = Repository::getInstance();
        $article = $repo->findBy(\MVC\Models\Article::class,['community' => $id]);
        $community = $repo->findOneBy(\MVC\Models\Community::class,['id' => $id]);

        if ($community === null){
            return new View('errors/404');
        } else {
            $view = new View('community/show');
            $view->assign('articles' , $article);
            $view->assign('community' , $community);
            return $view;
        }
    }
}