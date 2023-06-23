<?php

namespace App\Core;

use App\Controller\AboutController;
use App\Controller\AuthenticationController;
use App\Controller\CartController;
use App\Controller\ContactController;
use App\Controller\ErrorController;
use App\Controller\ProductsController;
use App\Controller\RegistrationController;
use App\Core\Library\LibraryLG;

class Router {
  private array $routes = [
    null => [AuthenticationController::class, 'handleLogin'],
    '/login' => [AuthenticationController::class, 'handleLogin'],
    '/logon' => [AuthenticationController::class, 'handleLoginClicked'],
    '/products' => [ProductsController::class, 'handleMainProductPage'],
    '/singleProduct' => [ProductsController::class, 'handleSinglePage'],
    '/cart' => [CartController::class, 'handleCart'],
    '/home' => [ProductsController::class, 'handleHomePage'],
    '/about' => [AboutController::class, 'handleAbout'],
    '/thankyou' => [CartController::class, 'thankYouCheckout'],
    '/contact' => [ContactController::class, 'handleContact'],
    '/registration' => [RegistrationController::class, 'handleRegister'],
    '/register' => [RegistrationController::class, 'handleRegister', true],
    '/logoff' => [AuthenticationController::class, 'handleLogOff'],
    '/logoff2' => [AuthenticationController::class, 'handleLogOff', true],
    '/err500' => [ErrorController::class, 'show500Error']
  ];

  public function handleUserRequest(): void {
    $requestUri = $_SERVER['REQUEST_URI'];
    $requestMethod = $_SERVER['REQUEST_METHOD'];

    $route = $this->findRoute($requestUri, $requestMethod);

    if ($route !== null) {
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

  private function findRoute(string $requestUri, string $requestMethod): ?array {
    foreach ($this->routes as $route => $handler) {
      if ($route === $requestUri) {
        return $handler;
      }
    }

    return null;
  }

  private function handleInvalidRoute(): void {
    $errorController = new ErrorController();
    $errorController->show404Error();
  }

  public static function redirect(?array $params = [], ?string $url = null): void {
    if (empty($url)) {
      $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
      $host = $_SERVER['HTTP_HOST'];
      $url = $protocol . $host;
    }

    if (!empty($params)) {
      $queryString = http_build_query($params);
      $url .= '?' . $queryString;
    }

    header("Location: $url");
    exit;
  }
}
