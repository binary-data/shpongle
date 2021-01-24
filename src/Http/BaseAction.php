<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

use Psr\Http\Message\ServerRequestInterface;

abstract class BaseAction implements ActionInterface
{
    public function getResponseVars(ServerRequestInterface $request): array
    {
        return [];
    }
}
