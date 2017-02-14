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
                        'title' => 'Community',
                        'text' => 'Community add',
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