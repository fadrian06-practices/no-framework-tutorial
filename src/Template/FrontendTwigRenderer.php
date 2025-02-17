<?php

declare(strict_types=1);

namespace NFT\Template;

use NFT\Menu\MenuReader;

final class FrontendTwigRenderer implements FrontendRenderer
{
  private $renderer;
  private $menuReader;

  function __construct(Renderer $renderer, MenuReader $menuReader)
  {
    $this->renderer = $renderer;
    $this->menuReader = $menuReader;
  }

  function render(string $template, array $data = []): string
  {
    $data = array_merge($data, ['menuItems' => $this->menuReader->readMenu()]);

    return $this->renderer->render($template, $data);
  }
}
