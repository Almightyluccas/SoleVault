<?php

namespace app\controller;

class ErrorController {

  public function show404Error() : void {
    http_response_code(404);
    include '..\app\view\error\404Error.php' ;
  }
  public function show500Error() : void {
    http_response_code(500) ;

  }

}