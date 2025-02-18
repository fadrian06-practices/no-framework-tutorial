<?php

declare(strict_types=1);

namespace NFT;

use Http\HttpRequest;

final class HttpRequestAdapter extends HttpRequest
{
    protected string $inputStream = '';
}
