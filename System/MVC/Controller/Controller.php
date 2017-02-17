<?php

namespace System\MVC\Controller;
use System\Dispatcher;
use System\View;

/**
 * Class Controller
 * @package System\MVC\Controller
 */
abstract class Controller
{

    /**
     * @param $path
     */
    public function view($path)
    {
        $file = APP_ROOT . '/MVC/View/' . $path . '.phtml';

        ob_start();

        if (file_exists($file) === true) {
            include_once $file;
        } else {
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
        }

        $content = ob_get_clean();
        include APP_ROOT . 'MVC/Layout/main.phtml';
    }

    /**
     * @param $data
     */
    public function json($data)
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit(0);
    }

    public function forward($url)
    {
        Dispatcher::getInstance()->dispatch($url);
        exit(0);
    }

    /**
     * @return bool
     */
    public function isAjax()
    {
        return true === isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && 'xmlhttprequest' === strtolower($_SERVER['HTTP_X_REQUESTED_WITH']);
    }

    /**
     * @return View
     */
    public function notFoundAction()
    {
        return new View('errors/404');
    }

}