<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Route;

final class Route
{
    public function __construct(
        private string $method ,
        private string $route,
        private string $handler,
        private string $group
    ) {}

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getRoute(): string
    {
        return $this->route;
    }

    public function getHandler(): string
    {
        return $this->handler;
    }

    public function getGroup(): string
    {
        return $this->group;
    }
}
