<?php

declare(strict_types=1);

namespace NFT\Page;

use function assert;
use function file_exists;
use function file_get_contents;

final class FilePageReader implements PageReader
{
    public function __construct(
        private readonly string $pageFolder
    ) {
    }

    public function readBySlug(string $slug): string
    {
        $path = "{$this->pageFolder}/{$slug}.md";

        if (! file_exists($path)) {
            throw new InvalidPageException($slug);
        }

        $contents = file_get_contents($path);
        assert($contents);

        return $contents;
    }
}
