<?php

namespace app\controller;

class AboutController {

  public function handleAbout() : void {
    include __DIR__ . '/../view/about.php' ;
  }

}