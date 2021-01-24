<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\Http\RequestAttribute;
use Binarydata\Shpongle\Http\ActionResolverInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ActionDispatcherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ActionResolverInterface $actionResolver
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $vars = $this->actionResolver
            ->resolve($request->getAttribute(RequestAttribute::ACTION))
            ->getResponseVars($request);

        return $handler->handle($request->withAttribute(RequestAttribute::RESPONSE_VARS, $vars));
    }
}
