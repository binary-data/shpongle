<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Route;

use JetBrains\PhpStorm\Pure;

final class FastRouteCollection implements RouteCollectionInterface
{
    /**
     * @var Route[]
     */
    private array $routes = [];

    public function get(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('GET', $route, $handler, $group);
    }

    public function post(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('POST', $route, $handler, $group);
    }

    public function put(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('PUT', $route, $handler, $group);
    }

    public function delete(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('DELETE', $route, $handler, $group);
    }

    public function patch(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('PATCH', $route, $handler, $group);
    }

    public function head(string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        return $this->addRoute('HEAD', $route, $handler, $group);
    }

    public function addRoute(string $httpMethod, string $route, string $handler, string $group = RouteCollectionInterface::GROUP_DEFAULT): self
    {
        $this->routes[] = new Route($httpMethod, $route, $handler, $group);

        return $this;
    }

    #[Pure]
    public function current(): Route|false
    {
        return current($this->routes);
    }

    public function next(): Route|false
    {
        return next($this->routes);
    }

    #[Pure]
    public function key(): int|null
    {
        return key($this->routes);
    }

    #[Pure]
    public function valid(): bool
    {
        return $this->current() !== false;
    }

    public function rewind(): bool
    {
        return reset($this->routes) !== false;
    }
}
