<?php

namespace MVC\Controller;

use System\Config;
use System\Database\Connection;
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

    /**
     * Register action
     */
    public function registerAction()
    {
        $database = Config::get('database');
        $login = $_POST['register_username'];
        $email = $_POST['register_email'];
        $password = $_POST['register_password'];

        $repeatPassword = $_POST['register_repeat_password'];

        if ($_POST['register_gender'] === 'male') {
            $gender = 0;
        } else if($_POST['register_gender'] === 'female') {
            $gender = 1;
        }

        $mysqli = new \mysqli(
            $database['host'],
            $database['username'],
            $database['password'],
            $database['database']
        );

        if (isset($_POST['register']) && $password === $repeatPassword) {
            $sql = "INSERT INTO users (login, email, password, gender)
            VALUES ('$login', '$email', '$password', $gender)";

            if ($mysqli->query($sql)) {
                echo '<script> alert("Your account created successfully"); </script>';
            } else
                echo '<script> alert("Error"); </script>';

        }
        else {
            echo '<script> alert("Паролі не співпадають!"); </script>';
        }

        $this->view('users/register');
    }

    public function testAction()
    {
        $statement = Connection::getInstance();
    }

}