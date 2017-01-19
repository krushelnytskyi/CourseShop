<?php

namespace System;

/**
 * Class Dispatcher
 * @package System
 */
class Dispatcher
{

    /**
     * Main dispatcher control class
     * @return void
     */

    public function dispatch()
    {
        $controller = null;
        $action = null;
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $urlParts = explode('/', $url);
        
        if (isset($urlParts[0])) { 
            $controller = $urlParts[0];
            $controller = 'MVC\Controller\\' . ucfirst($controller);
            if (isset($urlParts[1])) {
                $action = $urlParts[1];
            }
        }
        
        foreach (Config::get('router', 'urls') as $currentUrl => $rule) {
            if ($url === $currentUrl) {
                $controller = $rule['controller'];
                $action = $rule['action'];
                break;
            }
        }

        foreach (Config::get('router', 'patterns') as $pattern => $rule) {
            if (preg_match("/$pattern/", $url)) {
                foreach ($rule as $key => &$value) {
                   $value = preg_replace("/$pattern/", $value, $url);
                }
                
                $controller = $rule['controller'];
                $action = $rule['action'];
                break;
            }
        }

        $action = $action . 'Action';
        $main = APP_ROOT . 'MVC/Layout/main.phtml';
        $errors = APP_ROOT . '/MVC/View/errors/404.phtml';

        
        if (class_exists($controller) && method_exists($controller, $action)) {

            $controller = new $controller();
            $controller->$action();
        } else {
            if (file_exists($main)) {
                ob_start();
                if (file_exists($errors)) {
                    include_once $errors;
                }

                $content = ob_get_clean();
                include $main;
            } else {

                if (file_exists($errors)) {
                    include_once $errors;
                }      
            } 
        }    
    }  

}


