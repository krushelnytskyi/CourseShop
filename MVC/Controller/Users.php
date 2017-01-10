<?php

namespace MVC\Controller;

use System\MVC\Controller\Controller;

/**
 * Class Users
 * @package MVC\Controller
 */
class Users extends Controller
{

    /**
     * @action users/login
     */
    public function loginAction()
    {
        $this->view('users/login');
    }

}