<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\Http\RequestAttribute;
use FastRoute\Dispatcher;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RouterMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $dispatcher = require ROOT . 'config/routes.php';

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($routeInfo[0] === Dispatcher::FOUND) {
            return $handler->handle(
                $request
                    ->withAttribute(RequestAttribute::ACTION, $routeInfo[1])
                    ->withAttribute(RequestAttribute::ACTION_VARS, $routeInfo[2])
            );
        }

        return new Response(404); // TODO move to some notfoundresponsefactory
    }
}
