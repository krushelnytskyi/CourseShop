<?php
namespace System;


class Session
{
    
    public static function init() 
    {
        @session_start();
    }

    public static function set($key, $value) 
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key) 
    {
        if(isset($_SESSION[$key]))
        {
            return $_SESSION[$key];
        }
        else
        {
            return NULL;
        }
    }

    public static function destroy() 
    {
//        session_destroy();
        session_unset();
    }
}
