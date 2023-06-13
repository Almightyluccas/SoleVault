<?php

namespace app\controller;

use app\core\library\LibraryLG;
use app\core\Router;
use app\model\Registration;
use mysqli_sql_exception;

class RegistrationController {
  private function performRegister(): void {

    $user = LibraryLG::removeAngleBracket(strtolower(LibraryLG::getValue('username')));
    $pass = LibraryLG::removeAngleBracket(LibraryLG::getValue('password'));
    $passTwo = LibraryLG::removeAngleBracket(LibraryLG::getValue('password2'));
    if (trim($user) !== '') {
      if (trim($pass) !== '') {
        if (trim($passTwo) !== '') {
          if (trim($pass) === trim($passTwo)) {
            $db = new Registration();
            $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
            try {
              if ($db->register($user, $hashedPass)) {
                Router::redirect(['choice' => 'login']);
              } else {
                Router::redirect(['choice' => 'registration', 'message' => 'Userid Already In Use']);
              }
            } catch (mysqli_sql_exception $e) {
              error_log(var_export($e, true));
              Router::redirect(['choice' => 'err500']);
            }
          } else {
            Router::redirect(['choice' => 'registration', 'message' => "Passwords don't match"]);
          }
        } else {
          Router::redirect(['choice' => 'registration', 'message' => 'Please Confirm Password']);
        }
      } else {
        Router::redirect(['choice' => 'registration', 'message' => 'Please Enter Password']);
      }
    } else {
      Router::redirect(['choice' => 'registration', 'message' => 'Please Enter Username']);
    }


  }

  public function handleRegister(bool $performRegisterAction = false): void {
    include(__DIR__ . '/../view/registration.php');
    if ($performRegisterAction) {
      $this->performRegister();
    }
  }


}