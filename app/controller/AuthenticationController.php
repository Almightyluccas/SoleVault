<?php
namespace app\controller;

use app\core\Router;
use app\library\LibraryLG;
use app\model\Authentication;
use Exception;
use mysqli_sql_exception;

class AuthenticationController {

  private Authentication $auth ;
  public function __construct() {
    $this->auth = new Authentication() ;
  }

  private function successfulAuth(string $username, int $customerId, ?string $series = null) : void {
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
    Router::redirect(['choice' => 'home']);
  }

  private function destroyAuth(int $customerId, ?string $series = null) : void {
    session_unset() ;
    session_destroy() ;
    setcookie(session_name(), "", time() - 1, "/") ;
    setcookie('auth-rem', "" , time()-1, "/" ) ;
    if($series !== null) {
      try {
        $this->auth->removeRememberMe($customerId ,$series) ;
      } catch (mysqli_sql_exception $e) {
        error_log(var_export($e, true)) ;
        Router::redirect(['choice'=>'err500']) ;
      }
      Router::redirect(['choice' => 'login']);
    } else {
      try {
        $this->auth->removeAllRememberMe($customerId);
      } catch (mysqli_sql_exception $e) {
        error_log(var_export($e, true)) ;
        Router::redirect(['choice'=>'err500']) ;
      }

    }
  }
  private function setRememberMe(int $customerId) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $series = bin2hex(random_bytes(25)) ;
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        try {
          $this->auth->insertRememberMe($customerId, $series, $token) ;
        } catch (mysqli_sql_exception $e ) {
          error_log(var_export($e, true)) ;
          Router::redirect(['choice'=>'err500']);
        }
      } catch (mysqli_sql_exception | Exception $e) {
        echo $e ;
      }
    }
  }

  private function setRememberMeCookie(int $customerId, string $seriesHex, string $tokenHex) : void {
    $cookieValue = $customerId . '|' . $seriesHex . '|' . $tokenHex ;
    setcookie('auth-rem', $cookieValue, time() + (7 * 24 * 60 * 60), '/') ;
  }

  private function updateRememberMe(int $customerId , string $series) : void {
    if(isset($_GET['rememberMe'])) {
      try {
        $token = bin2hex(random_bytes(25)) ;
        $this->setRememberMeCookie($customerId, $series, $token);
        $this->auth->insertNewTokenRemMe($customerId, $series, $token);
      } catch (mysqli_sql_exception | Exception $e) {
        error_log(var_export($e, true)) ;
        Router::redirect(['choice'=>'err500']) ;
      }
    }
  }

  private function validateRememberMeCookie(array $cookieArr) : void {
    try {
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
        try {
          $username = $this->auth->getUsername($customerIdCookie) ;
          $this->successfulAuth($username, $customerIdCookie, $seriesBin) ;
        } catch (mysqli_sql_exception $e) {
          error_log(var_export($e, true)) ;
          Router::redirect(['choice' => 'err500']) ;
        }
      }else {
        $this->destroyAuth($customerIdCookie);
        Router::redirect(['choice' => 'login', 'authBreach' => '1']) ;
      }
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      Router::redirect(['choice' => 'err500']) ;
    }
  }
  private function checkRememberMe() : void {
    if (isset($_COOKIE['auth-rem'])) {
      $rememberMeCookie = explode('|',  $_COOKIE['auth-rem']) ;
      $this->validateRememberMeCookie($rememberMeCookie) ;
    }
  }
  private function checkForUserInputError(string $username, ?string $password) : ?string {
    if((trim($username) === '' || trim($username) === null) &&(trim($password) === '' ||trim($password) === null)) {
      return 'Empty Username and Password' ;
    } else if (trim($username) === '' || trim($username) === null) {
      return 'Empty Username' ;
    } elseif (trim($password) === '' || trim($password) === null) {
      return 'Empty Password';
    }
    return null ;
  }

  public function handleLogin() : void {
    include(__DIR__ . '/../view/login.php') ;
    $this->checkRememberMe() ;
  }

  public function handleLoginClicked() : void {
    $username = LibraryLG::removeAngleBracket(strtolower(LibraryLG::getValue('username'))) ;
    $password = LibraryLG::removeAngleBracket(LibraryLG::getValue('password')) ;
    $errorMessage = $this->checkForUserInputError($username, $password) ;
    if ($errorMessage) {
      Router::redirect(['choice' => 'login', 'message' => $errorMessage]);
      return ;
    }
    try {
      if ($this->auth->login($username, $password)) {
        try {
          $customerId = $this->auth->getCustomerId($username) ;
          $this->setRememberMe($customerId) ;
          $this->successfulAuth($username, $customerId) ;
          Router::redirect(['choice' => 'home']) ;
        } catch (mysqli_sql_exception $e) {
          error_log(var_export($e, true)) ;
          Router::redirect(['choice' => 'err500']) ;
        }
      } else {
        Router::redirect(['choice' => 'login', 'message' => 'Invalid-Login']) ;
      }
    } catch (mysqli_sql_exception $e) {
      error_log(var_export($e, true)) ;
      Router::redirect(['choice' => 'err500']) ;
    }
  }

  public function handleLogOff(bool $fullyLogOff = false) : void {
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