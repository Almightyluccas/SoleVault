<?php

namespace app\core ;

class Autoloader {
  public static function register() : void {
    spl_autoload_register(function($className) {
      $basePath = __DIR__ . '/../../' ;
      $classPath = str_replace('\\', '/', $className) ;
      $filePath = $basePath . $classPath . '.php' ;
      if (file_exists($filePath)) {
        require_once $filePath ;
      }
    }) ;
  }
}

Autoloader::register() ;