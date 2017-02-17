<?php

namespace System;

/**
 * Class View
 * @package System
 */
class View
{

    /**
     * @var string
     */
    protected $view;
    protected $layout;

    /**
     * @var array
     */
    protected $variables = [];

    public function __construct($document = null)
    {
        if ($document !== null) {
            $this->view($document);
        }
    }

    public function view($name)
    {
        $this->view = APP_ROOT . 'MVC/View/' . $name . '.phtml';
    }


    public function layout($name = null)
    {
        $layout = $name === null ? Config::get('app', 'default_layout') : $name;

        if ($layout !== null) {
            ob_start();
            include APP_ROOT . 'MVC/Layout/' . $layout . '.phtml';
            return ob_get_clean();
        }
    }

    public function getBody()
    {
        if ($this->view !== null) {

            ob_start();
            include_once $this->view;
            $content = ob_get_clean();

            $layout = Config::get('app', 'default_layout');

            if ($layout !== null) {
                return include APP_ROOT . 'MVC/Layout/' . $layout . '.phtml';
            }

            return $content;
        }

        return null;

    }

    public function assign($variable, $value)
    {
        $this->variables[$variable] = $value;
    }

    public function assignArray(array $array)
    {
        $this->variables = array_merge_recursive($this->variables, $array);
    }

    public function __get($name)
    {
        if (isset($this->variables[$name])) {
            return $this->variables[$name];
        }

        return null;
    }
}