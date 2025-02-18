<?php

declare(strict_types=1);

namespace NFT\Template;

use Twig\Environment;

final class TwigRenderer implements Renderer
{
    public function __construct(
        private readonly Environment $renderer
    ) {
    }

    public function render(string $template, array $data = []): string
    {
        return $this->renderer->render("{$template}.html", $data);
    }
}
