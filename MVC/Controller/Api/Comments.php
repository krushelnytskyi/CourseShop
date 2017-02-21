<?php

namespace MVC\Controller\Api;

use MVC\Models\Comment;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Strings;
use System\View;

/**
 * Class Users
 * @package MVC\Controller\Api
 */
class Comments extends Controller
{

    /**
     * Create comment action
     */
    public function newAction()
    {
        if ($this->isAjax() === false) {
            return $this->notFoundAction();
        }

        $result = [];

        $form = new Form(
            $_POST,
            [
                'article' => [],
                'body'    => [
                    new Strings(2, 2100)
                ]
            ]
        );

        if ($form->execute() === true) {
            $article = Repository::getInstance()
                ->findOneBy(
                    \MVC\Models\Article::class,
                    [
                        'id' => $form->getFieldValue('article')
                    ]
                );

            if ($article === null) {
                $result['message'] = 'Can not find Article';
            } else {
                /** @var \MVC\Models\Article $article */

                $comment = new Comment();
                $comment->setBody($form->getFieldValue('body'))
                    ->setParentId($article->getId())
                    ->setParentType(Comment::PARENT_TYPE_ARTICLE)
                    ->setUser(UserSession::getInstance()->getIdentity());

                if (Repository::getInstance()->save($comment) !== false) {
                    $view = new View();

                    $view->assignArray(
                        [
                            'article' => $article,
                            'comments' => Repository::getInstance()
                                ->findBy(Comment::class, [
                                    'parentId' => $article->getId()
                                ])
                        ]
                    );
                    $result['html'] = $view->layout('partial/comments-list');
                } else {
                    $result['message'] = 'Something gone wrong';
                }
            }

        } else {
            $result['messages'] = $form->getErrors();
        }

        $this->json($result);
    }

}