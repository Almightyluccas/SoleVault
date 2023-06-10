# Router Documentation

The Router class is responsible for routing incoming requests to the appropriate controller methods based on the specified routes.

## Class Structure

The Router class is defined in the `app\core\Router` namespace and contains the following properties and methods:

### Properties

- `routes`: An associative array that maps route names to their corresponding controller class and method.

### Methods

- `handleUserRequest()`: Handles the incoming request and calls the appropriate controller method based on the specified route.
- `handleInvalidRoute()`: Handles invalid routes and displays a 404 error page.

## Usage

To use the Router class, follow these steps:

1. Define the routes in the `$routes` property
2. Make sure each route in `$routes` calls the controller handler
3. Implement the `handleUserRequest()` method to handle incoming requests
4. Implement the `handleInvalidRoute()` method to handle invalid routes


## Conclusion

The Router class provides a flexible routing mechanism for mapping incoming requests to the appropriate controller
methods. By defining routes in the `$routes` property and implementing the `handleRequest()` method,
you can easily handle different routes and execute the corresponding controller methods.