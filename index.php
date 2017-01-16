<?php

define('APP_ROOT', __DIR__ . '/');

include_once 'System/autoloader.php';

use System\App;

$app = new App();
$app->run();

$dispatcher = new \System\Dispatcher();
$dispatcher->dispatch();