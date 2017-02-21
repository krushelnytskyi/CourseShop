<?php

namespace System;

use System\Pattern\Singleton;


/**
 * Class Dispatcher
 * @package System
 *
 * @method static Dispatcher getInstance()
 */
class Dispatcher
{

    use Singleton;

    /**
     * Main dispatcher control class
     *
     * @param bool $url
     */
    public function dispatch($url = false)
    {
        session_start();

        if ($url === false) {
            $url = trim($_SERVER['REQUEST_URI'], '/');
        }

        $urlParts = explode('/', $url);

        $controller = 'MVC\Controller\\' . ucfirst($urlParts[0]);
        $action = $urlParts[1];

        foreach (Config::get('router', 'urls') as $currentUrl => $rule) {
            if ($url === $currentUrl) {
                $controller = $rule['controller'];
                $action = $rule['action'];
            }
        }

        foreach (Config::get('router', 'patterns') as $patterns => $rule) {
            if (preg_match("/$patterns/", $url)) {
                $controller = preg_replace("/$patterns/", $rule['controller'], $url);
                $action = preg_replace("/$patterns/", $rule['action'], $url);
            }

        }

        $action = $action . 'Action';

        if (class_exists($controller) && method_exists($controller, $action)) {
            $controller = new $controller();
            $view = $controller->$action();

            if ($view instanceof View) {
                echo $view->getBody();
            }
        } else {
            ob_start();
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
            $content = ob_get_clean();
            include APP_ROOT . 'MVC/Layout/main.phtml';
        }
    }

}
