<?php

require_once '../app/core/Autoloader.php';
require_once '../app/core/Router.php' ;

use app\core\Autoloader;
use app\core\Router;


Autoloader::register() ;

$router = new Router();
$router->handleUserRequest() ;
