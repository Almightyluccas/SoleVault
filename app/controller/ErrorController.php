<?php

namespace app\controller;

class ErrorController {

  public function accountBreachErr() : void {
    include '..\app\view\error\accountBreachError.php' ;
  }

}