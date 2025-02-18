<?php

declare(strict_types=1);

namespace NFT\Menu;

final class ArrayMenuReader implements MenuReader
{
    public function readMenu(): array
    {
        return [
            [
                'href' => '/',
                'text' => 'Homepage',
            ],
            [
                'href' => '/page-one',
                'text' => 'Page One',
            ],
        ];
    }
}
