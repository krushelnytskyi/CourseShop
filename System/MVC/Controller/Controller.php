<?php

namespace System\MVC\Controller;

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

}