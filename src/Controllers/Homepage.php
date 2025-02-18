<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Request;
use Http\Response;
use NFT\Template\FrontendRenderer;

final class Homepage
{
  function __construct(
    private readonly Request $request,
    private readonly Response $response,
    private readonly FrontendRenderer $renderer
  ) {}

  function show(): void
  {
    $data = ['name' => $this->request->getParameter('name', 'stranger')];
    $html = $this->renderer->render('homepage', $data);
    $this->response->setContent($html);
  }
}
