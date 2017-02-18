<?php

namespace MVC\Controller;

use MVC\Models\Article;
use MVC\Models\Community;
use MVC\Models\Tag;
use MVC\Models\TagsInArticle;
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

    /**
     * @action tagSearch
     */
    public function tagSearchAction()
    {
        $tagValue = urldecode(explode('/', $_SERVER['REQUEST_URI'])[2]);
        $repo = Repository::getInstance();
        /** @var Tag $tag */
        $tag = $repo->findOneBy(Tag::class,['value'=>$tagValue]);
        if ($tag === null){
            return $this->notFoundAction();
        }
        $articles = [];
        /** @var TagsInArticle $article */
        foreach ($repo->findBy(TagsInArticle::class,['tag' => $tag->getId()]) as $value){
            $articles[] = $value->getArticle();
        }
        $view = new View('pages/home');
        $view->assign('articles', $articles);
        return $view;
    }
}