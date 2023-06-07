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
  private array $routes = [
    null => [AuthenticationController::class, 'checkRememberMe'],
    'login' => [AuthenticationController::class, 'checkRememberMe'],
    'logon' => [AuthenticationController::class, 'handleLogin'],
    'products' => [ProductsController::class, 'productPage'],
    'singleProduct' => [ProductsController::class, 'singlePage'],
    'cart' => [CartController::class, 'cart'],
    'home' => [ProductsController::class, 'homePage'],
    'about' => [AboutController::class, 'about'],
    'thankyou' => [CartController::class, 'thankYouCheckout'],
    'contact' => [ContactController::class, 'contact', ],
    'registration' => [RegistrationController::class, 'register' ],
    'register' => [RegistrationController::class, 'register', true],
    'logoff' => [AuthenticationController::class, 'logOff'],
    'logoff2' => [AuthenticationController::class, 'logOff', true],
    'acctBreach' => [ErrorController::class, 'accountBreachErr'],
  ];

  public function handleRequest(): void {
    $choice = LibraryLG::getValue('choice');

    if (isset($this->routes[$choice])) {
      $route = $this->routes[$choice];
      $controllerClass = $route[0];
      $method = $route[1];
      $arguments = $route[2] ?? [];
      $controller = new $controllerClass();

      if (!empty($arguments)) {
        $controller->$method($arguments);
      } else {
        $controller->$method();
      }
    } else {
      $this->handleInvalidRoute();
    }
  }
  private function handleInvalidRoute(): void {
    $errorController = new ErrorController();
    $errorController->show404Error();
  }
}
