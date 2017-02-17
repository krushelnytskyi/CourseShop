<?php

namespace MVC\Controller;

use MVC\Models\Comment;
use MVC\Models\Community;
use MVC\Models\User;
use MVC\Models\CommunityInsiders;
use MVC\Models\Tag;
use MVC\Models\TagsInArticle;
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

        list(, , $id) = explode('/', $_SERVER['REQUEST_URI']);

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
        if (Session::getInstance()->hasIdentity() == false) {
            $result = [
                'messages' => 'User not register'
            ];
        } else {
            $form = new Form(
                $_POST,
                [
                    'title' => [
                        new Strings(3, 255),
                    ],
                    'body' => [
                        new Strings(3, 1000),
                    ],
                    'tags' => [
                        new Strings(3, 255),
                    ],
                ]
            );
            if ($form->execute() === false) {
                $result['messages'] = $form->getErrors();
            } else {
                $repository = Repository::getInstance();
                /** @var User $user */
                $user = UserSession::getInstance()->getIdentity();
                $article = new \MVC\Models\Article();
                $article->setUser($user);
                $article->setTitle($form->getFieldValue('title'));
                $article->setBody($form->getFieldValue('body'));
                $article->setTags($form->getFieldValue('tags'));

                // todo $article->setCommunity

                $article->setRating(0);
                /** @var Community $community */
                $community = $repository->findOneBy(Community::class, ['id' => $form->getFieldValue('community')]);
                if ($community !== null) {
                    $article->setCommunity($community);
                    if (null == $repository->findOneBy(CommunityInsiders::class, ['id' => $community->getId(), 'user' => $user->getId()])) {
                        $article->setIsModerated(!((bool)$community->isSecured()));
                    } else {
                        $article->setIsModerated(true);
                    }
                }
                $result = $repository->save($article);
                if ($result !== false) {
                    $tags = explode(' ', $form->getFieldValue('tags'));
                    foreach ($tags as $value) {
                        /** @var Tag $tag */
                        $tag = $repository->findOneBy(Tag::class, ['value' => $value]);
                        if ($tag === null) {
                            $tag = new Tag();
                            $tag->setValue($value);
                            $tagId = $repository->save($tag);
                        } else {
                            $tagId = $tag->getId();
                        }
                        $tagInArticle = new TagsInArticle();
                        $tagInArticle->setTag($tagId)->setArticle($result);
                        $repository->save($tagInArticle);
                    }
                    $result['redirect'] = '/';
                } else {
                    $result['messages'] = 'Something gone wrong';
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
        list(, $id) = explode('/', $url);
        $repo = Repository::getInstance();
        $article = $repo->findOneBy(\MVC\Models\Article::class, ['id' => $id]);

        if ($article === null) {
            return $this->notFoundAction();
        } else {
            $view = new View('article/show');
            $view->assign('article', $article);
            $view->assign('comments', Repository::getInstance()
                ->findBy(Comment::class, [
                    'parent' => $article->getId()
                ])
            );
            return $view;
        }
    }

}