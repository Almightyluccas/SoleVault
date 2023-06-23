<?php

require_once '../app/core/Autoloader.php';
require_once '../app/core/Router.php';
require __DIR__.'/../vendor/autoload.php' ;

use app\core\Autoloader;
use app\core\Router;


Autoloader::register() ;

$router = new Router();
$router->handleUserRequest() ;
