<?php

declare(strict_types=1);

namespace NFT\Menu;

interface MenuReader
{
  /** @return array{href: string, text: string}[] */
  function readMenu(): array;
}
