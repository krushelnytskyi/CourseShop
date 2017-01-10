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

        if (file_exists($file) === true) {
            include_once $file;
        } else {
            include_once APP_ROOT . '/MVC/View/errors/404.phtml';
        }
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