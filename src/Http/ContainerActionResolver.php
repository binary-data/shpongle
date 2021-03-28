<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

use Binarydata\Shpongle\Http\Exception\ActionNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Throwable;

class ContainerActionResolver implements ActionResolverInterface
{
    public function __construct(private ContainerInterface $container) {}

    public function resolve(string $className): MiddlewareInterface
    {
        try {
            return $this->container->get($className);
        } catch (Throwable $e) {
            throw new ActionNotFoundException("action '{$className}' resolve error: {$e->getMessage()}", 0, $e);
        }
    }
}
