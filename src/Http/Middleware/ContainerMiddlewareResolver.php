<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use InvalidArgumentException;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;

class ContainerMiddlewareResolver implements MiddlewareResolverInterface
{
    public function __construct(
        private ContainerInterface $container
    ) {}

    public function resolve(string $className): MiddlewareInterface
    {
        $middleware = $this->container->get($className);

        if (! $middleware instanceof MiddlewareInterface) {
            throw new InvalidArgumentException('middleware must be an instance of MiddlewareInterface');
        }

        return $middleware;
    }
}
