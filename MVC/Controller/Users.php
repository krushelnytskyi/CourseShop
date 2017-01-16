<?php

namespace MVC\Controller;

use System\MVC\Controller\Controller;
use MVC\Models\User;
use System\Session;

/**
 * Class Users
 * @package MVC\Controller
 */
class Users extends Controller
{

    private  $user;
    /**
     * @action users/login
     */
    function __construct()
    {
        $this->user = new User();
    }
    
    public function loginAction()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') 
        {
            $this->view('users/login');
        } 
        elseif ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            if (isset($_POST['email']) && isset($_POST['password']))
            {
                $user = $this->user->getByEmail($_POST['email']);
                if ($user && $this->user->login($_POST['password'])) 
                {
                    $this->view('users/login');
                }
                else
                {
                    echo '<script> alert("User dose not exist")</script>'; //only for test (trash)
                    $this->view('users/login');
                }
            }
        }

    }

    public function logoutAction()
    {
        Session::destroy();
        header("Location: /users/login");
       // $this->view('users/login');
    }

    public function registerAction()
    {
        $this->view('users/register');
    }


}