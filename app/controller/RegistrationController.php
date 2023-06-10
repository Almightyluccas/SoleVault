<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Authentication;

class RegistrationController {
  public function handleRegister(bool $performRegisterAction = false ) : void {
    if ($performRegisterAction) {
      $user = LibraryLG::removeAngleBracket(strtolower(LibraryLG::getValue('username'))) ;
      $pass = LibraryLG::removeAngleBracket(LibraryLG::getValue('password')) ;
      $passTwo = LibraryLG::removeAngleBracket(LibraryLG::getValue('password2')) ;
      if(trim($pass) === trim($passTwo)) {
        $db = new Authentication() ;
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT) ;
        if ($db->register($user, $hashedPass)) {
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