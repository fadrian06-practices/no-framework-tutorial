<?php

declare(strict_types=1);

namespace NFT;

use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Http\HttpRequest;
use Http\HttpResponse;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

use function FastRoute\simpleDispatcher;

require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(E_ALL);

$environment = 'development';

/**
 * Register the error handler
 */
$whoops = new Run;

if ($environment !== 'production') {
  $whoops->pushHandler(new PrettyPageHandler);
} else {
  $whoops->pushHandler(static function (Throwable $error): void {
    echo 'Todo: Friendly error page and send an email to the developer';
  });
}

$whoops->register();

$request = new class($_GET, $_POST, $_COOKIE, $_FILES, $_SERVER) extends HttpRequest {
  protected $inputStream = '';
};

$response = new HttpResponse;

$routeDefinitionCallback = function (RouteCollector $router) {
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

    $class = new $className($response);
    $class->$method($vars);
    break;
}

foreach ($response->getHeaders() as $header) {
  header($header, false);
}

echo $response->getContent();
