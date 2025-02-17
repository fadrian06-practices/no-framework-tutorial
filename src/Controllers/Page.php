<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Response;
use NFT\Page\InvalidPageException;
use NFT\Page\PageReader;
use NFT\Template\FrontendRenderer;

final class Page
{
  private $response;
  private $renderer;
  private $pageReader;

  function __construct(
    Response $response,
    FrontendRenderer $renderer,
    PageReader $pageReader
  ) {
    $this->response = $response;
    $this->renderer = $renderer;
    $this->pageReader = $pageReader;
  }

  function show($params)
  {
    $slug = $params['slug'];

    try {
      $data['content'] = $this->pageReader->readBySlug($slug);
    } catch (InvalidPageException $error) {
      $this->response->setStatusCode(404);
      return $this->response->setContent('404 - Page not found');
    }

    $html = $this->renderer->render('page', $data);
    $this->response->setContent($html);
  }
}
