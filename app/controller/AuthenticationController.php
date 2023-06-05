<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Database;
use app\model\Authentication;
use Exception;

class AuthenticationController {

  private Authentication $auth ;
  public function __construct() {
    $this->auth = new Authentication() ;
  }

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

  private function destroyAuth($customerId, $series = null) : void {
    session_unset() ;
    session_destroy() ;
    setcookie(session_name(), "", time() - 1, "/") ;
    setcookie('auth-rem', "" , time()-1, "/" ) ;
    if($series !== null) {
      $this->auth->removeRememberMe($customerId ,$series) ;
      header("Location: index.php") ;
    } else {
      $this->auth->removeAllRememberMe($customerId);

    }
  }
  private function setRememberMe($customerId) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $series = bin2hex(random_bytes(25)) ;
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        $this->auth->insertRememberMe($customerId, $series, $token) ;
      } catch (Exception $e) {
        echo $e ;
      }
    }
  }

  private function setRememberMeCookie($customerId, $seriesHex, $tokenHex) : void {
    $cookieValue = $customerId . '|' . $seriesHex . '|' . $tokenHex ;
    setcookie('auth-rem', $cookieValue, time() + (7 * 24 * 60 * 60), '/') ;
  }

  private function updateRememberMe($customerId , $series) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        $this->auth->insertNewTokenRemMe($customerId, $series, $token);
      } catch (Exception $e) {
        echo $e->getMessage() ;
      }
    }
  }

  private function validateRememberMeCookie($cookieArr) : void {
      $customerIdCookie = intval($cookieArr[0]) ;
      $seriesBin = $cookieArr[1] ;
      $tokenBin = $cookieArr[2] ;
      $result = $this->auth->getRememberMeCred($customerIdCookie, $seriesBin) ;
      $validateCallback = fn($result) => (
        !empty($result) &&
        $customerIdCookie === $result[0]['customerId'] &&
        $seriesBin === $result[0]['series'] &&
        $tokenBin === $result[0]['token']
      );
      if ($validateCallback($result)) {
        $this->successfulAuth(
          $this->auth->getUsername($customerIdCookie),
          $customerIdCookie,
          $seriesBin
        );
      }else {
        $this->destroyAuth($customerIdCookie);
        header("Location: index.php?choice=login&authBreach=1") ;
      }
  }

  public function checkRememberMe() : void {
    if (isset($_COOKIE['auth-rem'])) {
      $rememberMeCookie = explode('|',  $_COOKIE['auth-rem']) ;

      $this->validateRememberMeCookie($rememberMeCookie) ;
    }
  }

  private function checkForUserInputError($username, $password) : string {
    $message = '' ;

      if((trim($username) === '' || trim($username) === null) &&(trim($password) === '' ||trim($password) === null)) {
        $message = 'Empty Username and Password' ;
      } else if (trim($username) === '' || trim($username) === null) {
        $message = 'Empty Username' ;
      } elseif (trim($password) === '' || trim($password) === null) {
        $message = 'Empty Password' ;
      }

      if ($message !== '') {
        include(__DIR__ . '/../view/login.php') ;
        return $message ;
      }
    return $message ;
  }


  public function handleLogin() : string {


    $username = strtolower(LibraryLG::getValueString('username')) ;
    $password = LibraryLG::getValue('password') ;
    $message = $this->checkForUserInputError($username, $password) ;
    if ($message !== '') {
      return $message ;
    }
    if ($this->auth->login($username, $password)) {
      $customerId = $this->auth->getCustomerId($username) ;
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