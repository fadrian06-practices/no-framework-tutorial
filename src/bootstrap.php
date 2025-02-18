<?php

declare(strict_types=1);

namespace NFT;

use Auryn\InjectorException;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Http\Request;
use Http\Response;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

use function FastRoute\simpleDispatcher;

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = getenv('ENVIRONMENT') ?: 'dev';

/**
 * Register the error handler
 */
$whoops = new Run;

if ($environment === 'dev') {
  $whoops->pushHandler(new PrettyPageHandler);
} else {
  $whoops->pushHandler(static function (Throwable $error): void {
    ini_set('error_log', __DIR__ . '/../logs/error.log');
    assert(in_array($error->getCode(), [0, 1, 3, 4], true));
    error_log("Error: {$error->getMessage()}", $error->getCode());
    echo 'An Error happened';
  });
}

$whoops->register();

$injector = require __DIR__ . '/dependencies.php';
$request = $injector->make(Request::class);
$response = $injector->make(Response::class);

$routeDefinitionCallback = static function (RouteCollector $router) {
  $routes = require __DIR__ . '/routes.php';

  foreach ($routes as $route) {
    $router->addRoute($route[0], $route[1], $route[2]);
  }
};

$dispatcher = simpleDispatcher($routeDefinitionCallback);
$routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getPath());

switch ($routeInfo[0]) {
  case Dispatcher::NOT_FOUND:
    $response->setContent('404 - Page not found');
    $response->setStatusCode(404);
    break;
  case Dispatcher::METHOD_NOT_ALLOWED:
    $response->setContent('405 - Method not allowed');
    $response->setStatusCode(405);
    break;
  case Dispatcher::FOUND:
    $className = $routeInfo[1][0];
    $method = $routeInfo[1][1];
    $vars = $routeInfo[2];

    $class = $injector->make($className);
    $callback = [$class, $method];
    assert(is_callable($callback));

    try {
      $injector->execute($callback, $vars);
    } catch (InjectorException) {
      call_user_func($callback, $vars);
    }

    break;
}

foreach ($response->getHeaders() as $header) {
  header($header, false);
}

echo $response->getContent();
