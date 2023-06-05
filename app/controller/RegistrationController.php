<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Authentication;

class RegistrationController {
  public function register($performRegisterAction = false ) : void {
    if ($performRegisterAction) {
      $user = LibraryLG::getValue('username') ;
      $pass = LibraryLG::getValue('password') ;
      $passTwo = LibraryLG::getValue('password2') ;
      if(trim($pass) === trim($passTwo)) {
        $db = new Authentication() ;
        if ($db->register($user, $pass)) {
          header("Location: index.php") ;
        } else {
          $message = "ERROR: Userid Already In Use" ;
          include(__DIR__ . '/../view/registration.php') ;
        }
      } else {
        $message = "Error: Passwords don't match" ;
        include(__DIR__ . '/../view/registration.php') ;
      }
    } else {
      include(__DIR__ . '/../view/registration.php') ;
    }
  }

}