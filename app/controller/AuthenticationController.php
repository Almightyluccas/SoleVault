<?php

namespace app\controller;

use app\library\LibraryLG;
use app\model\Database;
use app\model\Login;
use Exception;

class AuthenticationController {

  private function setRememberMeFirstTime($customerId) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $login = new Login() ;

        $series = random_bytes(25) ;
        $token = random_bytes(25) ;
        $seriesHex = bin2hex($series) ;
        $tokenHex = bin2hex($token) ;
        $cookieValue = $customerId . '|' . $seriesHex . '|' . $tokenHex;

        setcookie('auth-rem', $cookieValue, time() + (7 * 24 * 60 * 60), '/') ;
        $login->insertRememberMe($customerId, $seriesHex, $tokenHex) ;

      } catch (Exception $e) {
        echo $e ;
      }
    }
  }
  private function setRememberMeSecond($customerId , $series) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $login = new Login() ;
        $token = bin2hex(random_bytes(25)) ;
        $cookieValue = $customerId . '|' . $series . '|' . $token;
        setcookie('auth-rem', $cookieValue, time() + (7 * 24 * 60 * 60), '/') ;
        $login->insertNewTokenRemMe($customerId, $series, $token);

      } catch (Exception $e) {
        echo $e ;
      }
    }
  }
  public function checkRememberMe() : void {
    if (isset($_COOKIE['auth-rem'])) {
      $login = new Login() ;
      $rememberMeString = $_COOKIE['auth-rem'] ;
      $rememberMeParts = explode('|', $rememberMeString) ;
      $customerIdCookie = intval($rememberMeParts[0]) ;
      $seriesBin = $rememberMeParts[1] ;
      $tokenBin = $rememberMeParts[2] ;

      $result = $login->getRememberMeCred($customerIdCookie) ;
      if(!empty($result)) {
        if ($customerIdCookie === $result[0]['customerId'] && $seriesBin === $result[0]['series']
          && $tokenBin === $result[0]['token']) {
          session_start() ;
          $_SESSION['username'] = $login->getUsername($result[0]['customerId']) ;
          $_SESSION['series'] = $result[0]['series'] ;
          $_SESSION['customerId'] = $result[0]['customerId'] ;
          $_SESSION['ON'] = true ;

          $this->setRememberMeSecond($result[0]['customerId'], $result[0]['series']) ;
          setcookie(session_name(), session_id(), time() + 600, "/") ;

          $_SESSION['LAST_ACTIVITY'] = time();
          header("Location: index.php?choice=home") ;

        } else {
          echo 'not equal' ;
        }
      } else {
        echo 'null value returned' ;
      }

    }
  }


  public function login() : string {
    $message = '';
    $username = strtolower(LibraryLG::getValue('username')) ;
    $password = LibraryLG::getValue('password') ;

    //handles error message
    if(trim($username) === '' && trim($password) === '') {
      $message = 'Empty Username and Password' ;
      $password = $username = '' ;
      $choice = null ;
      include(__DIR__ . '/../view/login.php') ;
      return $message;
    } else if (trim($username) === '') {
      $message = 'Empty Username' ;
      $password = $username = '' ;
      $choice = null ;
      include(__DIR__ . '/../view/login.php') ;
      return $message;
    } elseif (trim($password) === '') {
      $message = 'Empty Password' ;
      $password = $username = '' ;
      $choice = null;
      include(__DIR__ . '/../view/login.php') ;
      return $message ;
    }
    $db = new Login() ;



    if ($db->login($username, $password)) {
      session_start() ;

      $_SESSION['username'] = $username ;
      $_SESSION['password'] = $password ;
      $_SESSION['customerId'] = $db->getCustomerId($username) ;
      $_SESSION['ON'] = true ;

      $this->setRememberMeFirstTime($db->getCustomerId($username)) ;
      setcookie(session_name(), session_id(), time() + 600, "/") ;
      $_SESSION['LAST_ACTIVITY'] = time();
      header("Location: index.php?choice=home") ;
      exit() ;
    } else {
      $message = 'Invalid-login' ;
        $password = $username = '' ;
        $choice = null;
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
      $login = new Login() ;
      $rememberMeString = $_COOKIE['auth-rem'] ;
      $rememberMeParts = explode('|', $rememberMeString) ;
      $customerId = intval($rememberMeParts[0]) ;
      $series = $rememberMeParts[1] ;
      $login->removeRememberMe($customerId ,$series) ;

      session_unset() ;
      session_destroy() ;
      setcookie(session_name(), "", time() - 1, "/") ;
      setcookie('auth-rem', "" , time()-1, "/" ) ;
      $message = 'Logoff-Successful' ;
      header("Location: index.php") ;

    } else {
      include(__DIR__ . '/../view/logoff.php') ;
    }
  }

}