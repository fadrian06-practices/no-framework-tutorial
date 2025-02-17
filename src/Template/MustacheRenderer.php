<?php

declare(strict_types=1);

namespace NFT\Template;

use Mustache_Engine;

final class MustacheRenderer implements Renderer
{
    private $engine;

    function __construct(Mustache_Engine $engine)
    {
        $this->engine = $engine;
    }

    function render(string $template, array $data = []): string
    {
        return $this->engine->render($template, $data);
    }
}
