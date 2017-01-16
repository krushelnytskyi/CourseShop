<?php

namespace MVC\Models;
use System\Database;
use System\App;
use System\Session;

/**
 * Class User
 * @package MVC\Models
 */
class User
{
    protected $db;

    function __construct()
    {

        $this->db = App::$app->getDb();
        Session::init();
        
        //$this->db=Database::DB();
    }

    function __destruct()
    {
        $this->db = null;
    }

    /**
     * @param $email 
     * @param $password
     * @return bool
     */
    public function getUser($email, $password)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE email=? AND password=?");
        $query->execute([$email,$password]);
        $result =$query->fetch(\PDO::FETCH_LAZY);
        //Session::init();
        
        if($result)
        {
            Session::set('logged',true);
            Session::set('userid',$result->id);
            Session::set('email',$result->email);
            return $result;
       }
        else
        {
            return false;
        }
    }
    
    public function login($password)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE password=?");
        $query->execute([$password]);
        $result =$query->fetch(\PDO::FETCH_LAZY);
        //Session::init();

        if($result)
        {
            Session::set('logged',true);
            Session::set('email',$result->email);
            return true;
        }
        else
        {
            return false;
        }
    }
    public function getByEmail($email)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE email=? ");
        $query->execute([$email]);
        $result =$query->fetch(\PDO::FETCH_LAZY);
       // Session::init();

        if($result)
        {
            Session::set('logged',true);
            Session::set('email',$result->email);
            return true;
        }
        else
        {
            return false;
        }

    }

    /*public function getUserById($userid)
    {
        $query = $this->db->prepare("SELECT * FROM user WHERE id=? ");
        $query->execute([$userid]);
        $result =$query->fetch(\PDO::FETCH_LAZY);

        if (isset($result))
        {
            return $result;
        }
        else
        {
            return false;
        }
        
    }*/

}