<?php

namespace MVC\Controller;

use MVC\Models\Article;
use MVC\Models\Comment;
use MVC\Models\User;
use MVC\Models\Opinions;
use System\Auth\Session;
use System\Auth\UserSession;
use System\Form;
use System\MVC\Controller\Controller;
use System\ORM\Repository;
use System\Validators\Regular;

class OpinionsController extends Controller
{

    /**
     * Like on article
     */
    public function articleLikeAction()
    {
        $contentId = $this->checkAll();
        $this->setOpinion($contentId, Opinions::CONTENT_TYPE_ARTICLE, Opinions::LIKE);
        $this->json(['message' => 'saved!']);
    }

    /**
     * Like on article
     */
    public function articleDisLikeAction()
    {
        $contentId = $this->checkAll();
        $this->setOpinion($contentId, Opinions::CONTENT_TYPE_ARTICLE, Opinions::DISLIKE);
        $this->json(['message' => 'saved!']);

    }

    /**
     * Like on article
     */
    public function commentLikeAction()
    {
        $contentId = $this->checkAll();
        $this->setOpinion($contentId, Opinions::CONTENT_TYPE_COMMENT, Opinions::LIKE);
        $this->json(['message' => 'saved!']);

    }

    /**
     * Like on article
     */
    public function commentDisLikeAction()
    {
        $contentId = $this->checkAll();
        $this->setOpinion($contentId, Opinions::CONTENT_TYPE_COMMENT, Opinions::DISLIKE);
        $this->json(['message' => 'saved!']);

    }

    /**
     * @return mixed|null
     */
    protected function checkAll()
    {
        if (Session::getInstance()->hasIdentity()) {
            $form = new Form($_POST, ['id' => [new Regular('[0-9]+')]]);
            if ($form->execute()) {
                return $form->getFieldValue('id');
            } else {
                $result = $form->getErrors();
            }
            $this->json($result);
        }
        exit(0);
    }

    /**
     * @param int $contentId
     * @param int $contentType
     * @param int $op opinion
     */
    protected function setOpinion($contentId, $contentType, $op)
    {
        $repo = Repository::getInstance();
        /** @var User $user */
        $user = UserSession::getInstance()->getIdentity();
        /** @var Opinions $opinion */
        $opinion = $repo->findOneBy(Opinions::class, ['user' => $user->getId(), 'content_type' => $contentType, 'content_id' => $contentId]);
        if ($opinion === null) {
            $opinion = new Opinions();
            $opinion->setUser($user->getId())->setContent($contentId)->setOpinion($op)->setContentType($contentType);
            $id = $repo->save($opinion);
            $opinion = $repo->findOneBy(Opinions::class,['id' => $id]);
            $this->calculateRating(1,$op,$contentType,$opinion->getContent());      //todo refactor
        } else {
            if ($opinion->getOpinion() === $op) {
                $this->calculateRating(-1,$op,$contentType,$opinion->getContent()); //todo refactor
                $repo->delete($opinion);
            } else {
                $opinion->setOpinion($op);
                $this->flipRating($op,$contentType,$opinion->getContent()); //todo refactor
                $repo->update($opinion);
            }
        }
    }

    /**
     * @param int $i
     * @param int $op
     * @param int $contentType
     * @param Article|Comment $content
     */
    protected function calculateRating($i, $op, $contentType, $content)
    {
        if ($op === Opinions::LIKE) {
            $content->addLikes($i);
        } elseif ($op === Opinions::DISLIKE) {
            $content->addDisLikes($i);
        }
        /** @var User $user */
        $user = $content->getUser();
        $repo = Repository::getInstance();
        if ($contentType === Opinions::CONTENT_TYPE_ARTICLE) {
            if ($op === Opinions::LIKE) {
                $user->addRating($i*2);
            } else {
                $user->addRating(-$i*2);
            }
            $content->recalculateRating();
        } else {
            if ($op === Opinions::LIKE) {
                $user->addRating($i);
            } else {
                $user->addRating(-$i);
            }
        }
        $repo->update($content);
        $repo->update($user);
    }

    /**
     * @param int $op
     * @param int $contentType
     * @param Article|Comment $content
     */
    protected function flipRating($op, $contentType, $content){
        if ($op === Opinions::LIKE) {
            $content->addLikes(1);
            $content->adddisLikes(-1);
        } elseif ($op === Opinions::DISLIKE) {
            $content->addLikes(-1);
            $content->adddisLikes(1);
        }
        /** @var User $user */
        $user = $content->getUser();
        $repo = Repository::getInstance();
        if ($contentType === Opinions::CONTENT_TYPE_ARTICLE) {
            if ($op === Opinions::LIKE) {
                $user->addRating(4);
            } else {
                $user->addRating(-4);
            }
            $content->recalculateRating();
        } else {
            if ($op === Opinions::LIKE) {
                $user->addRating(2);
            } else {
                $user->addRating(-2);
            }
        }
        $repo->update($content);
        $repo->update($user);
    }

}