<?php

declare(strict_types=1);

namespace NFT\Template;

use NFT\Menu\MenuReader;

final class FrontendTwigRenderer implements FrontendRenderer
{
  function __construct(
    private readonly Renderer $renderer,
    private readonly MenuReader $menuReader
  ) {}

  function render(string $template, array $data = []): string
  {
    $data = array_merge($data, ['menuItems' => $this->menuReader->readMenu()]);

    return $this->renderer->render($template, $data);
  }
}
