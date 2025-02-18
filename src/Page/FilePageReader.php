<?php

declare(strict_types=1);

namespace NFT\Page;

final class FilePageReader implements PageReader
{
  function __construct(private readonly string $pageFolder)
  {
  }

  function readBySlug(string $slug): string
  {
    $path = "$this->pageFolder/$slug.md";

    if (!file_exists($path)) {
      throw new InvalidPageException($slug);
    }

    $contents = file_get_contents($path);
    assert($contents);

    return $contents;
  }
}
