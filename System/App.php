<?php

namespace System;

use MVC\Models\User;

class App
{
    
    public static $app;

    private $db;
    private $user;

    public function getDb() 
    {
        return $this->db;
    }
    
    public function run() 
    {
        Session::init();

        self::$app = new self();
        self::$app->db = Database::DB();
/*
        if (Session::get('logged')) 
        {
            self::$app->user = User::getUserById(Session::get('userId'));
        }*/

       // self::$app->user = Auth::getCurrentUser();
    }
}