<?php

namespace MVC\Controller;

use System\MVC\Controller\Controller;

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
        $this->view('pages/home');
    }

    public function articleAction()
    {
        $this->view('pages/article');
    }

    public function articleAddAction()
    {
        $this->view('article/add');
    }

}