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
        $file   = APP_ROOT . '/MVC/View/' . $path . '.phtml';
        $main   = APP_ROOT . 'MVC/Layout/main.phtml';
        $errors = APP_ROOT . '/MVC/View/errors/404.phtml';

        if (file_exists($main)) {
            
            ob_start();

            if (file_exists($file) === true) {
            include_once $file;
            } else {
                if (file_exists($errors)) {
                    include_once $errors;
                }
            
            }

            $content = ob_get_clean();
            include $main;

        }  else {
            if (file_exists($file)) {
                include_once $file;
            }
            
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