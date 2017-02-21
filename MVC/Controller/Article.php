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
use System\Validators\Regular;
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
            $form = new Form(
                $_POST,
                [
                    'delete' => [
                        new Regular('[0-9]+')
                    ]
                ]
            );
            if (false !== $form->execute()) {
                /** @var User $user */
                $user = UserSession::getInstance()->getIdentity();
                if ($user !== null) {
                    $grade = $user->getGrade();
                    if ($grade === User::USER_GRADE_MODERATOR || $grade === User::USER_GRADE_ADMIN) {
                        $repo = Repository::getInstance();
                        $articleId = $form->getFieldValue('delete');
                        $article = Repository::getInstance()->findOneBy(\MVC\Models\Article::class, ['id' => $articleId]);
                        if ($article !== null) {
                            $tagsInArticle = $repo->findBy(TagsInArticle::class, ['article' => $articleId]);
                            $comments = $repo->findBy(Comment::class, ['article' => $articleId]);
                            foreach ($tagsInArticle as $tagInArticle) {
                                $repo->delete($tagInArticle);
                            }
                            foreach ($comments as $comment) {
                                $repo->delete($comment);
                            }
                            /** TODO:  DELETE ALL OPINIONS WHICH RELATE TO
                             *  TODO:  ARTICLE OR COMMENTS IN CURRENT ARTICLE */
                            $repo->delete($article);
                            $result['title'] = 'Success.';
                            $result['text'] = 'Article has been deleted!';
                            $result['redirect'] = '/';
                        } else {
                            $result['title'] = 'Delete error.';
                            $result['text'] = 'Article with id ' . $articleId . ' not found in database';
                            $result['redirect'] = '/';
                        }
                    } else {
                        $result['message'] = 'No permission';
                    }
                }else {
                    $result['message'] = 'No permission';
                }
            } else {
                $result['messages'] = $form->getErrors();
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
        if (!Session::getInstance()->hasIdentity()) {
            $result = [
                'message' => 'You must log-in for this action!'
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
                    'community' => [
                        new Regular('-?[0-9]+')
                    ]
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
                $article->setRating(0);
                /** @var Community $community */
                $community = $repository->findOneBy(Community::class, ['id' => $form->getFieldValue('community')]);
                if ($community !== null) {
                    $article->setCommunity($community);
                    if ($community->isSecured()) {
                        if (null == $repository->findOneBy(CommunityInsiders::class, ['id' => $community->getId(), 'user' => $user->getId()]) || $user->getId() === $community->getUser()->getId()) {
                            $article->setModerated(!$community->isSecured());
                        } else $article->setModerated(true);
                    } else {
                        $article->setModerated(true);
                    }
                }
                $tags = array_unique(explode(' ', $form->getFieldValue('tags')));
                $article->setTags(implode(' ', $tags));
                $articleId = $repository->save($article);
                if ($articleId !== false) {
                    $tags = array_unique(explode(' ', $form->getFieldValue('tags')));
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
                        $tagInArticle->setTag($tagId)->setArticle($articleId);
                        $repository->save($tagInArticle);
                    }
                    $result['title'] = 'Success!';
                    $result['text'] = 'Article has been created!';
                    $result['redirect'] = '/article/'.$articleId;
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
                    'parentId' => $article->getId()
                ])
            );
            return $view;
        }
    }

}