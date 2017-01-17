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

    public function registerAction()
    {
        $database = include 'config/database.php';
        $login = $_POST[register_username];
        $email = $_POST[register_email];
        $password = $_POST[register_password];
        $repeat_password = $_POST[register_repeat_password];
        if ($_POST['register_gender']==="male")
        {
            $gender = 0;
        }
        else if($_POST['register_gender'] ==="female")
        {
            $gender = 1;
        }
        $mysqli = new \mysqli(
            $database['host'],
            $database['username'],
            $database['password'],
            $database['database']
        );

        if(isset($_POST['register']) && $password ===$repeat_password ) {
            $sql = "INSERT INTO Users (login, email, password, gender)
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

}