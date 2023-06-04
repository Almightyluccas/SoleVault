<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Database;
use app\model\Login;
use Exception;

class AuthenticationController {

  private function successfulAuth($username, $customerId, $series = null) : void {
    session_start() ;
    $_SESSION['username'] = $username ;
    $_SESSION['customerId'] = $customerId ;
    $_SESSION['ON'] = true ;
    if($series !== null) {
      $_SESSION['series'] = $series ;
      $this->updateRememberMe($customerId, $series) ;
    }
    setcookie(session_name(), session_id(), time() + 600, "/") ;
    $_SESSION['LAST_ACTIVITY'] = time() ;
    header("Location: index.php?choice=home") ;
  }
  private function destroyAuth($customerId, $series) : void {
    $login = new Login() ;
    $login->removeRememberMe($customerId ,$series) ;
    session_unset() ;
    session_destroy() ;
    setcookie(session_name(), "", time() - 1, "/") ;
    setcookie('auth-rem', "" , time()-1, "/" ) ;
    header("Location: index.php?choice=logon") ;
  }

  private function setRememberMe($customerId) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $login = new Login() ;
        $series = bin2hex(random_bytes(25)) ;
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        $login->insertRememberMe($customerId, $series, $token) ;
      } catch (Exception $e) {
        echo $e ;
      }
    }
  }
  private function setRememberMeCookie($customerId, $seriesHex, $tokenHex) : void {
    $cookieValue = $customerId . '|' . $seriesHex . '|' . $tokenHex;
    setcookie('auth-rem', $cookieValue, time() + (7 * 24 * 60 * 60), '/') ;
  }

  private function updateRememberMe($customerId , $series) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $login = new Login() ;
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        $login->insertNewTokenRemMe($customerId, $series, $token);
      } catch (Exception $e) {
        echo $e->getMessage() ;
      }
    }
  }

  private function validateRememberMeCookie($cookieArr) : void {
    try{
      $login = new Login() ;
      $customerIdCookie = intval($cookieArr[0]) ;
      $seriesBin = $cookieArr[1] ;
      $tokenBin = $cookieArr[2] ;
      $result = $login->getRememberMeCred($customerIdCookie, $seriesBin) ;
      if(!empty($result)) {
        if ($customerIdCookie === $result[0]['customerId'] && $seriesBin === $result[0]['series']
          && $tokenBin === $result[0]['token']) {
          $this->successfulAuth(
            $login->getUsername($customerIdCookie), $customerIdCookie, $seriesBin
          );
        } else {
          throw new Exception('not equal')  ;
        }
      } else {
        throw new Exception('null value returned') ;
      }
    }catch (Exception $e) {
      echo $e->getMessage() ;
    }
  }

  public function checkRememberMe() : void {
    if (isset($_COOKIE['auth-rem'])) {
      $rememberMeCookie = explode('|',  $_COOKIE['auth-rem']) ;
      $this->validateRememberMeCookie($rememberMeCookie) ;
    }
  }

  private function handleUserInput($username, $password) {
    $message = '' ;
      if(trim($username) === '' && trim($password) === '') {
        $message = 'Empty Username and Password' ;
      } else if (trim($username) === '') {
        $message = 'Empty Username' ;
      } elseif (trim($password) === '') {
        $message = 'Empty Password' ;
      }

      if ($message !== '') {
        include(__DIR__ . '/../view/login.php') ;
      }
    return $message ;
  }


  public function login() : string {
    $message = '';
    $username = strtolower(LibraryLG::getValue('username')) ;
    $password = LibraryLG::getValue('password') ;
    $message = $this->handleUserInput($username, $password) ;
    if ($message !== '') {
      return $message ;
    }
    $login = new Login() ;
    $customerId = $login->getCustomerId($username) ;
    if ($login->login($username, $password)) {
      $this->setRememberMe($customerId);
      $this->successfulAuth(
        $username, $customerId
      );
      exit() ;
    } else {
      $message = 'Invalid-login' ;
        include(__DIR__ . '/../view/login.php') ;
      return $message ;
    }
  }

  public function firstVisit() : void {
    $database = new Database() ;
    $database->createDatabase('\sql\dbCreationScript.sql') ;
    include(__DIR__ . '/../view/login.php') ;
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

  public function logOff($fullyLogOff = false) : void {
    if ($fullyLogOff) {
      session_start() ;
      $rememberMeParts = explode('|', $_COOKIE['auth-rem']) ;
      $customerId = intval($rememberMeParts[0]) ;
      $series = $rememberMeParts[1] ;
      $this->destroyAuth($customerId, $series);
    } else {
      include(__DIR__ . '/../view/logoff.php') ;
    }
  }

}