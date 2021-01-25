<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\Http\RequestAttribute;
use Binarydata\Shpongle\Http\ActionResolverInterface;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ActionDispatcherMiddleware implements MiddlewareInterface
{
    public function __construct(
        private ActionResolverInterface $actionResolver,
        private ResponseFactoryInterface $responseFactory
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $action = $this->actionResolver->resolve($request->getAttribute(RequestAttribute::ACTION));

        $redirectUrl = $action->redirectTo();

        if ($redirectUrl !== null) {
            return $this->responseFactory
                ->createResponse(StatusCodeInterface::STATUS_MOVED_PERMANENTLY)
                ->withHeader('Location', $redirectUrl);
        }

        $vars = $action->getResponseVars($request);

        return $handler->handle($request->withAttribute(RequestAttribute::RESPONSE_VARS, $vars));
    }
}
