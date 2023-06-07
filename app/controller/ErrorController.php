<?php

namespace app\controller;

class ErrorController {

  public function show404Error() : void {
    include '..\app\view\error\404Error.php' ;
  }

}