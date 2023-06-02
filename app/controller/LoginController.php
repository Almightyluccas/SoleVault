<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Database;
use app\model\Login;

class LoginController {


  public function login() : string {
    $message = '';
    $username = LibraryLG::getValue('username');
    $password = LibraryLG::getValue('password');

    if (trim($username) === '') {
      $message = 'Empty Username';
      if (!empty($message)) {
        $password = $username = '';
        $choice = null;
        include('..\app\view\login.php');
      }
      return $message;
    } elseif (trim($password) === '') {
      $message = 'Empty Password';
      if (!empty($message)) {
        $password = $username = '';
        $choice = null;
        include('..\app\view\login.php');
      }
      return $message;
    }

    $db = new Login();

    if ($db->login($username, $password)) {
      session_start();

      if (isset($_SESSION['ON'])) {
        LibraryLG::sessionValidator() ;
      }

      $_SESSION['username'] = $username;
      $_SESSION['password'] = $password;
      $_SESSION['customerId'] = $db->getCustomerId($username);
      $_SESSION['ON'] = true;

      $lifetime = 600;
      setcookie(session_name(), session_id(), time() + $lifetime, "/");
      $_SESSION['LAST_ACTIVITY'] = time();

      header("Location: index.php?choice=home");
      if (!empty($message)) {
        $password = $username = '';
        $choice = null;
        include('..\app\view\login.php');
      }
      exit();
    } else {
      $message = 'Invalid-login';
      if (!empty($message)) {
        $password = $username = '';
        $choice = null;
        include('..\app\view\login.php');
      }
      return $message;
    }

  }
  public function logon() : void {
    $database = new Database() ;
    $database->createDatabase('\sql\dbCreationScript.sql') ;
    include('..\app\view\login.php') ;
  }

  public function register($performRegisterAction = false ) : void {
    if ($performRegisterAction) {
      $user = LibraryLG::getValue('username') ;
      $pass = LibraryLG::getValue('password') ;
      $passTwo = LibraryLG::getValue('password2') ;

      if(trim($pass) === trim($passTwo)) {
        $db = new Login() ;
        if ($db->register($user, $pass)) {
          header("Location: index.php") ;
        } else {
          $message = "ERROR: Userid Already In Use" ;
          include('..\app\view\registration.php') ;
        }

      } else {
        $message = "Error: Passwords don't match" ;
        include('..\app\view\registration.php') ;
      }
    } else {
      include('..\app\view\registration.php') ;
    }

  }
  public function logOff($fullyLogOff = false) : void {
    if ($fullyLogOff) {
      session_start() ;
      session_unset() ;
      session_destroy() ;
      setcookie(session_name(), "", time() - 1, "/") ;
      $message = 'Logoff-Successful' ;
      include('..\app\view\login.php') ;
    } else {
      include('..\app\view\logoff.php') ;
    }

  }

}