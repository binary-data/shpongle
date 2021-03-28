<?php

declare(strict_types=1);

namespace Binarydata\Shpongle;

use Binarydata\Shpongle\Http\Middleware\MiddlewareResolverInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class App implements RequestHandlerInterface
{
    /**
     * @param string[] $pipe
     * @param RequestHandlerInterface $default
     * @param MiddlewareResolverInterface $middlewareResolver
     */
    public function __construct(
        private array $pipe,
        private RequestHandlerInterface $default,
        private MiddlewareResolverInterface $middlewareResolver
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (empty($this->pipe)) {
            return $this->default->handle($request);
        }

        $middlewareClass = array_shift($this->pipe);
        $middleware = $this->middlewareResolver->resolve($middlewareClass);

        return $middleware->process($request, $this);
    }

    public function push(string $middlewareClass): void
    {
        $this->pipe[] = $middlewareClass;
    }
}
