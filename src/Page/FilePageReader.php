<?php

declare(strict_types=1);

namespace NFT\Page;

final class FilePageReader implements PageReader
{
  private $pageFolder;

  function __construct(string $pageFolder)
  {
    $this->pageFolder = $pageFolder;
  }

  function readBySlug(string $slug): string
  {
    $path = "$this->pageFolder/$slug.md";

    if (!file_exists($path)) {
      throw new InvalidPageException($slug);
    }

    return file_get_contents($path);
  }
}
