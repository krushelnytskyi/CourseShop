<?php

namespace MVC\Controller;

use System\MVC\Controller\Controller;
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
        return $view;
    }

    public function articleAction()
    {
        $view = new View('pages/article');
        return $view;
    }

    public function articleAddAction()
    {
        $view = new View('pages/articleAdd');
        return $view;
    }

    public function communityCreateAction()
    {
        $view = new View('pages/communityCreate');
        return $view;
    }
}