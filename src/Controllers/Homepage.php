<?php

declare(strict_types=1);

namespace NFT\Controllers;

use Http\Response;

final class Homepage
{
  private $response;

  function __construct(Response $response)
  {
    $this->response = $response;
  }

  function show(): void
  {
    $this->response->setContent('Hello World');
  }
}
