<?php

declare(strict_types=1);

namespace NFT;

use Http\HttpRequest;
use Http\HttpResponse;
use Throwable;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

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

$content = '<h1>Hello World</h1>';
$response->setContent($content);

foreach ($response->getHeaders() as $header) {
  header($header, false);
}

echo $response->getContent();
