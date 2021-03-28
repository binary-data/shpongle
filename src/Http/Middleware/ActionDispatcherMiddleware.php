<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\App;
use Binarydata\Shpongle\Http\RequestAttribute;
use Binarydata\Shpongle\Http\ActionResolverInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ActionDispatcherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ActionResolverInterface $actionResolver,
        private array $middleware,
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if (! $handler instanceof App) {
            return $handler->handle($request);
        }

        $group = $request->getAttribute(RequestAttribute::ACTION_GROUP);

        /** @var MiddlewareInterface $middleware */
        foreach ($this->middleware[$group]['before'] ?? [] as $middleware) {
            $handler->push($middleware);
        }

        $handler->push($request->getAttribute(RequestAttribute::ACTION_CLASS));

        /** @var MiddlewareInterface $middleware */
        foreach ($this->middleware[$group]['after'] ?? [] as $middleware) {
            $handler->push($middleware);
        }

        return $handler->handle($request);
    }
}
