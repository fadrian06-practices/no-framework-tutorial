<?php

declare(strict_types=1);

use Auryn\Injector;
use Http\HttpResponse;
use Http\Request;
use Http\Response;
use NFT\HttpRequestAdapter;

$injector = new Injector;

$injector->alias(Request::class, HttpRequestAdapter::class);
$injector->share(HttpRequestAdapter::class);

$injector->define(HttpRequestAdapter::class, [
    ':get' => $_GET,
    ':post' => $_POST,
    ':cookies' => $_COOKIE,
    ':files' => $_FILES,
    ':server' => $_SERVER,
]);

$injector->alias(Response::class, HttpResponse::class);
$injector->share(HttpResponse::class);

return $injector;
