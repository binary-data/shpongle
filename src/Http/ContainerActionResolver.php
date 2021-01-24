<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

use Binarydata\Shpongle\Http\Exception\ActionNotFoundException;
use Psr\Container\ContainerInterface;
use Throwable;

class ContainerActionResolver implements ActionResolverInterface
{
    public function __construct(private ContainerInterface $container) {}

    public function resolve(string $className): ActionInterface
    {
        try {
            return $this->container->get($className);
        } catch (Throwable) {
            throw new ActionNotFoundException("action '{$className}' not found");
        }
    }
}
