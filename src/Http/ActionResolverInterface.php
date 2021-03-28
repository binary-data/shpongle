<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

use Psr\Http\Server\MiddlewareInterface;

interface ActionResolverInterface
{
    public function resolve(string $className): MiddlewareInterface;
}
