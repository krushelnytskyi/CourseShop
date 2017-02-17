<?php

namespace MVC\Controller;

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
 * Class Article
 * @package MVC\Controller
 */
class Article extends Controller
{

    /**
     * Create view action
     *
     * @return View
     */
    public function createAction()
    {
        $view = new View('article/create');
        $view->assign('communities', Repository::getInstance()->findBy(Community::class));

        return $view;
    }

    public function editAction()
    {
        $view = $this->createAction();

        list(,,$id) = explode('/', $_SERVER['REQUEST_URI']);

        if (($article = Repository::getInstance()->findOneBy(\MVC\Models\Article::class, ['id' => $id]))) {

            $view->assign('article', $article);
        }

        return $view;
    }

    /**
     * Article json delete action
     */
    public function deleteAction()
    {
        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $grade = UserSession::getInstance()->getIdentity();
            if ($grade !== null) {
                $role = $grade->getGrade();
                if ($role === User::USER_GRADE_MODERATOR && User::USER_GRADE_ADMIN) {
                    $delete = Repository::getInstance()->findOneBy(\MVC\Models\Article::class);
                    if (Repository::getInstance()->delete($delete) !== false) {
                        $result['title'] = 'Delete';
                        $result['text'] = 'Article delete';
                        $result['redirect'] = '/';
                    } else {
                        $result['message'] = 'Somethasdaing gone wrong';
                    }
                } else {
                        $result['message'] = 'No permission';
                }
            }
        }
        $this->json($result);
    }

    /**
     * Article json create action
     */
    public function newAction()
    {
        $result = [];
        if(Session::getInstance()->hasIdentity() == false){
            $result = [
                'messages' => 'User not register'
            ];
        } else {
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
                $result['messages'] = $form->getErrors();
            } else {
                $article = new \MVC\Models\Article();
                $article->setUser(UserSession::getInstance()->getIdentity());
                $article->setTitle($form->getFieldValue('title'));
                $article->setBody($form->getFieldValue('body'));
                $article->setTags($form->getFieldValue('tags'));

                // todo $article->setCommunity

                $article->setRating(0);
                if (Repository::getInstance()->save($article) !== false) {
                    $result['title'] = 'Article';
                    $result['text'] = 'Article add';
                    $result['redirect'] = '/';
                } else {
                    $result['message'] = 'Something gone wrong';
                }
            }
        }
        $this->json($result);
    }

    /**
     * Show article view action
     *
     * @return View
     */
    public function showAction()
    {
        $url = trim($_SERVER['REQUEST_URI'], '/');
        list(,$id) = explode('/', $url);
        $repo = Repository::getInstance();
        $article = $repo->findOneBy(\MVC\Models\Article::class,['id' => $id]);

        if ($article === null){
            return new View('errors/404');
        } else {
            $view = new View('article/show');
            $view->assign('article', $article);
            return $view;
        }
    }
    
}