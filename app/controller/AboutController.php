<?php

namespace app\controller;

class AboutController {

  public function handleAbout() : void {
    include('..\app\view\about.php') ;
  }

}