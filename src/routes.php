<?php

declare(strict_types=1);

use NFT\Controllers\Homepage;

return [
  ['GET', '/', [Homepage::class, 'show']]
];
