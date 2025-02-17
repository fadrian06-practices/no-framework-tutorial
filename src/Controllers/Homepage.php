<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Request;
use Http\Response;

final class Homepage
{
  private $request;
  private $response;

  function __construct(Request $request, Response $response)
  {
    $this->request = $request;
    $this->response = $response;
  }

  function show(): void
  {
    $content = '<h1>Hello World</h1>';
    $content .= 'Hello ' . $this->request->getParameter('name', 'stranger');
    $this->response->setContent($content);
  }
}
