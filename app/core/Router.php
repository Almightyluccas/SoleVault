<?php

namespace app\core ;

use app\controller\AboutController;
use app\controller\CartController;
use app\controller\ContactController;
use app\controller\AuthenticationController;
use app\controller\ErrorController;
use app\controller\ProductsController;
use app\controller\RegistrationController;
use app\library\LibraryLG;

class Router {
  public function handleRequest(): void {
    $choice = LibraryLG::getValue('choice') ;

    switch ($choice) {

      case null:

      case 'login':
        $loginController = new AuthenticationController();
        $loginController->checkRememberMe() ;
        $loginController->firstVisit() ;
        break ;

      case 'logon':
        //TODO: Switch to ajax for error message so page doesn't need to reload
        $loginController = new AuthenticationController() ;
        $loginController->handleLogin() ;
        break;

      case 'products':
        $prodControl = new ProductsController() ;
        $prodControl->productPage() ;
        break ;

      case 'singleProduct':
         $prodControl = new ProductsController() ;
         $prodControl->singlePage() ;
        break ;

      case 'cart':
        $cartControl = new CartController() ;
        $cartControl->cart() ;
        break ;

      case 'home':
        $prodControl = new ProductsController() ;
        $prodControl->homePage() ;
        break ;

      case 'about':
        $aboutControl = new AboutController() ;
        $aboutControl->about() ;
        break ;

      case 'thankyou':
        $cartControl = new CartController() ;
        $cartControl->thankYouCheckout() ;
        break ;

      case 'contact':
        $contactControl = new ContactController() ;
        $contactControl->contact() ;
        break ;

      case 'registration':
        $loginControl = new RegistrationController() ;
        $loginControl->register() ;
        break ;

      case 'register':
        $loginControl = new RegistrationController() ;
        $loginControl->register(true) ;
        break ;

      case 'logoff':
        $loginControl = new AuthenticationController() ;
        $loginControl->logOff() ;
        break ;

      case 'logoff2':
        $loginControl = new AuthenticationController() ;
        $loginControl->logOff(true) ;
        break ;
      case 'acctBreach' :
        $errorControl = new ErrorController() ;
        $errorControl->accountBreachErr() ;
    }
  }


}
