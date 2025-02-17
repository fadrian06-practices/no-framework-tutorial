<?php

declare(strict_types=1);

namespace NFT\Page;

interface PageReader
{
  function readBySlug(string $slug): string;
}
