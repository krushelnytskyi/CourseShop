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

        $controller = null;
        $action = null;

        $urlParts = explode('/', $url);
        $controller = $urlParts[0];
        $action = $urlParts[1];

        foreach (Config::get('router', 'urls') as $currentUrl => $rule) {
            if ($url === $currentUrl) {
                $controller = $rule['controller'];
                $action = $rule['action'];
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

        if (strpos('MVC\\', $controller) !== 0) {
            $controller = 'MVC\Controller\\' . ucfirst($controller);
        }

        $action = $action . 'Action';

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            $controller->$action();
        } else {
            ob_start();
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
            $content = ob_get_clean();
            include APP_ROOT . 'MVC/Layout/main.phtml';
        }
    }

}
