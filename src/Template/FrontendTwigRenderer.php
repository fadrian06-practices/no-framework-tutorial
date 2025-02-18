<?php

declare(strict_types=1);

namespace NFT\Template;

use NFT\Menu\MenuReader;
use function array_merge;

final class FrontendTwigRenderer implements FrontendRenderer
{
    public function __construct(
        private readonly Renderer $renderer,
        private readonly MenuReader $menuReader
    ) {
    }

    public function render(string $template, array $data = []): string
    {
        $data = array_merge($data, [
            'menuItems' => $this->menuReader->readMenu(),
        ]);

        return $this->renderer->render($template, $data);
    }
}
