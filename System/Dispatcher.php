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
        $url = trim($_SERVER['REQUEST_URI'], '/');
        $urlParts = explode('/', $url);

        $controller = 'MVC\Controller\\' . ucfirst($urlParts[0]);
        $action = $urlParts[1] . 'Action';

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            $controller->$action();
        } else {
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
        }
    }

}