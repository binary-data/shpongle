<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Route;

use Iterator;

interface RouteCollectionInterface extends Iterator
{
    public const GROUP_DEFAULT = 'default';

    public function get(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function post(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function put(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function delete(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function patch(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function head(string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
    public function addRoute(string $httpMethod, string $route, string $handler, string $group = self::GROUP_DEFAULT): self;
}
