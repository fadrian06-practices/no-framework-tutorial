<?php

declare(strict_types=1);

namespace NFT\Template;

use Twig\Environment;

final class TwigRenderer implements Renderer
{
  private $renderer;

  function __construct(Environment $renderer)
  {
    $this->renderer = $renderer;
  }

  function render(string $template, array $data = []): string
  {
    return $this->renderer->render("$template.html", $data);
  }
}
