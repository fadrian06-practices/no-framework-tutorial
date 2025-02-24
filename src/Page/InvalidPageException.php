<?php

declare(strict_types=1);

namespace NFT\Page;

use Exception;

final class InvalidPageException extends Exception
{
  function __construct(string $slug, int $code = 0, Exception $previous = null)
  {
    $message = "No page with the slug `$slug` was found";

    parent::__construct($message, $code, $previous);
  }
}
