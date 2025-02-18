<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Response;
use NFT\Page\InvalidPageException;
use NFT\Page\PageReader;
use NFT\Template\FrontendRenderer;

final class Page
{
  function __construct(
    private readonly Response $response,
    private readonly FrontendRenderer $renderer,
    private readonly PageReader $pageReader
  ) {}

  /** @param array{slug: string} $params */
  function show(array $params): void
  {
    $slug = $params['slug'];
    $data = [];

    try {
      $data['content'] = $this->pageReader->readBySlug($slug);
      $html = $this->renderer->render('page', $data);
      $this->response->setContent($html);
    } catch (InvalidPageException) {
      $this->response->setStatusCode(404);
      $this->response->setContent('404 - Page not found');
    }
  }
}
