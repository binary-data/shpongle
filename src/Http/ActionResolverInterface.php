<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http;

interface ActionResolverInterface
{
    public function resolve(string $className): ActionInterface;
}
