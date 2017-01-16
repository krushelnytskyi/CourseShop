<?php

namespace System;

/**
 * Class Database
 * @package System
 */
class Database
{
    function DB()
    {
        $host = Config::get('database','host');
        $username = Config::get('database','username');
        $password = Config::get('database','password');
        $database = Config::get('database','database');
        $charset = Config::get('database','charset');

            
        static $instance;
        
        if ($instance === null) {
            $opt = array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
                \PDO::ATTR_EMULATE_PREPARES => FALSE,
            );

            
            $dsn = 'mysql:host=' . $host . ';dbname=' . $database . ';charset=' . $charset;
            $instance = new \PDO($dsn, $username, $password, $opt);
        }
        return $instance;
    }


}