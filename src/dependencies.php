<?php

declare(strict_types=1);

use Auryn\Injector;
use Http\HttpResponse;
use Http\Request;
use Http\Response;
use NFT\HttpRequestAdapter;
use NFT\Menu\ArrayMenuReader;
use NFT\Menu\MenuReader;
use NFT\Page\FilePageReader;
use NFT\Page\PageReader;
use NFT\Template\FrontendRenderer;
use NFT\Template\FrontendTwigRenderer;
use NFT\Template\MustacheRenderer;
use NFT\Template\Renderer;
use NFT\Template\TwigRenderer;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

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

$injector->alias(Renderer::class, TwigRenderer::class);

$injector->delegate(Environment::class, static function (): Environment {
  $loader = new FilesystemLoader(dirname(__DIR__) . '/templates');
  $twig = new Environment($loader);

  return $twig;
});

$injector->define(FilePageReader::class, [
  ':pageFolder' => __DIR__ . '/../pages',
]);

$injector->alias(PageReader::class, FilePageReader::class);
$injector->share(FilePageReader::class);

$injector->alias(FrontendRenderer::class, FrontendTwigRenderer::class);

$injector->alias(MenuReader::class, ArrayMenuReader::class);
$injector->share(ArrayMenuReader::class);

return $injector;
