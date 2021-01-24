<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Psr\Http\Server\MiddlewareInterface;

interface MiddlewareResolverInterface
{
    public function resolve(string $className): MiddlewareInterface;
}
