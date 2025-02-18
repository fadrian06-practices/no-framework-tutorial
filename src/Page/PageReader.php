<?php

declare(strict_types=1);

namespace NFT\Page;

interface PageReader
{
    public function readBySlug(string $slug): string;
}
