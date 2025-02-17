<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Request;
use Http\Response;
use NFT\Template\Renderer;

final class Homepage
{
  private $request;
  private $response;
  private $renderer;

  function __construct(Request $request, Response $response, Renderer $renderer)
  {
    $this->request = $request;
    $this->response = $response;
    $this->renderer = $renderer;
  }

  public function show(): void
  {
    $data = [
      'name' => $this->request->getParameter('name', 'stranger'),
    ];

    $html = $this->renderer->render('homepage', $data);
    $this->response->setContent($html);
  }
}
