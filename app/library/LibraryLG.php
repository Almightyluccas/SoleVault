<?php

namespace app\library;

class LibraryLG {
  public static function getValue(mixed $valueName) : ?string {
    isset($_GET[$valueName]) ? $value = $_GET[$valueName] : $value = null ;
    return $value;
  }
  public static function getValueString(string $valueName) : ?string {
    isset($_GET[$valueName]) ? $value = $_GET[$valueName] : $value = '' ;
    return $value;
  }
  public static function removeAngleBracket(string $inputString): string {
    return str_replace(['<', '>'], '', $inputString) ;
  }
  public static function postValue(mixed $x) : ?string {
    isset($_POST[$x]) ? $value = $_POST[$x] : $value = null ;
    return $value ;
  }
  public static function isNumber(mixed $valueToEvaluate) {
    if ($valueToEvaluate==null|| $valueToEvaluate==""|| trim($valueToEvaluate)==" ") {
      return false ;
    } else if(filter_var($valueToEvaluate, FILTER_VALIDATE_FLOAT)) {
      return true ;
    } else {
      return false ;
    }
  }
  public static function isInteger(mixed $valueToEvaluate) {
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
      header( 'Location: index.php?message=Invalid-Authentication' );
    } else {
      if (isset($_SESSION['LAST_ACTIVITY'])) {
        if ( time() - $_SESSION['LAST_ACTIVITY'] > 600) {
          session_unset();
          session_destroy();
          setcookie(session_name(),"",time()-1,"/");
          setcookie(session_name(),"",time()-1);
          header( 'Location: index.php?message=Session-Time-Out' );
        }
      }
    }
  }

}
