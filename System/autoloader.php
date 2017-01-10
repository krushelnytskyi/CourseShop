<?php

spl_autoload_register(function ($class) {

    if (!class_exists($class)) {
        $file = str_replace('\\', '/', $class) . '.php';

        if (file_exists($file)) {
            include_once $file;
        }
    }

});