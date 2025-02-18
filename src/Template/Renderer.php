<?php

declare(strict_types=1);

namespace NFT\Template;

interface Renderer
{
  /** @param array<string, mixed> $data */
  function render(string $template, array $data = []): string;
}
