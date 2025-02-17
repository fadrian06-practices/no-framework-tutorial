<?php

declare(strict_types=1);

use Auryn\Injector;
use Http\HttpResponse;
use Http\Request;
use Http\Response;
use NFT\HttpRequestAdapter;
use NFT\Template\MustacheRenderer;
use NFT\Template\Renderer;

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

$injector->alias(Renderer::class, MustacheRenderer::class);

$injector->define(Mustache_Engine::class, [
    ':options' => [
        'loader' => new Mustache_Loader_FilesystemLoader(dirname(__DIR__) . '/templates', [
            'extension' => '.html',
        ]),
    ],
]);

return $injector;
