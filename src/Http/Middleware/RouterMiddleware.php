<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\Http\RequestAttribute;
use Binarydata\Shpongle\Http\Route\Route;
use Binarydata\Shpongle\Http\Route\RouteCollectionInterface;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function FastRoute\simpleDispatcher;

final class RouterMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        /** @var RouteCollectionInterface $routes */
        /** @noinspection PhpIncludeInspection */
        $routes = require ROOT . 'config/routes.php';

        $dispatcher = simpleDispatcher(static function (RouteCollector $r) use ($routes) {
            /** @var Route $route */
            foreach ($routes as $route) {
                $r->addRoute($route->getMethod(), $route->getRoute(), $route);
            }
        });

        $routeInfo = $dispatcher->dispatch($request->getMethod(), $request->getUri()->getPath());

        if ($routeInfo[0] === Dispatcher::FOUND) {
            /** @var Route $route */
            $route = $routeInfo[1];

            return $handler->handle(
                $request
                    ->withAttribute(RequestAttribute::ACTION_CLASS, $route->getHandler())
                    ->withAttribute(RequestAttribute::ACTION_VARS, $routeInfo[2])
                    ->withAttribute(RequestAttribute::ACTION_GROUP, $route->getGroup())
            );
        }

        return new Response(404); // TODO move to some notfoundresponsefactory
    }
}
