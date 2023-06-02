<?php

namespace app\library;

class LibraryLG {
  public static function getValue($valueName) : ?string {
    isset($_GET[$valueName]) ? $value = $_GET[$valueName] : $value = null ;
    return $value;
  }
  public static function postValue($x) : ?string {
    isset($_POST[$x]) ? $value = $_POST[$x] : $value = null ;
    return $value ;
  }
  public static function isNumber($valueToEvaluate) {
    if ($valueToEvaluate==null|| $valueToEvaluate==""|| trim($valueToEvaluate)==" ") {
      return false ;
    } else if(filter_var($valueToEvaluate, FILTER_VALIDATE_FLOAT)) {
      return true ;
    } else {
      return false ;
    }
  }
  public static function isInteger($valueToEvaluate) {
    if ($valueToEvaluate==null|| $valueToEvaluate==""|| trim($valueToEvaluate)==" ") {
      return false;
    } else if(filter_var($valueToEvaluate, FILTER_VALIDATE_INT)) {
      return true ;
    } else {
      return false;
    }
  }
  public static function sessionValidator() : void {
    session_start();
    if ($_SESSION['ON'] ==false || $_SESSION['ON']==null) {
      session_unset();
      session_destroy();
      setcookie(session_name(),"",time()-1,"/");
      setcookie(session_name(),"",time()-1);
      header( 'Location: index.php?message=Invalid-Login' );;
      //$message="invalid-login";
      //include('index.php');
    } else {
      if (isset($_SESSION['LAST_ACTIVITY'])) {
        if ( time() - $_SESSION['LAST_ACTIVITY'] > 600) {
          session_unset();     // unset $_SESSION variable for the run-time
          session_destroy();   // destroy session data in storage
          setcookie(session_name(),"",time()-1,"/");
          setcookie(session_name(),"",time()-1);

          header( 'Location: index.php?message=Session-Time-Out' );
        }
      }
    }
  }

}
