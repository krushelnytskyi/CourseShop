<?php

define('APP_ROOT', __DIR__ . '/');

include_once 'System/autoloader.php';

$dispatcher = new \System\Dispatcher();
$dispatcher->dispatch();