<?php

declare(strict_types=1);

namespace NFT\Template;

interface Renderer
{
  function render(string $template, array $data = []): string;
}
