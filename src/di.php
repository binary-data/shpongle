<?php

declare(strict_types=1);

use Binarydata\Shpongle\App;
use Binarydata\Shpongle\Http\ContainerActionResolver;
use Binarydata\Shpongle\Http\Middleware\ContainerMiddlewareResolver;
use Binarydata\Shpongle\Http\Middleware\MiddlewareResolverInterface;
use Binarydata\Shpongle\Http\Middleware\NotFoundHandler;
use Binarydata\Shpongle\Http\ActionResolverInterface;
use Binarydata\Shpongle\Template\TemplateRendererInterface;
use Binarydata\Shpongle\Template\TwigRenderer;
use Laminas\HttpHandlerRunner\Emitter\EmitterInterface;
use Laminas\HttpHandlerRunner\Emitter\SapiEmitter;
use Nyholm\Psr7\Factory\Psr17Factory;
use Nyholm\Psr7Server\ServerRequestCreator;
use Nyholm\Psr7Server\ServerRequestCreatorInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

return [
    ServerRequestCreatorInterface::class => fn (Psr17Factory $f) => new ServerRequestCreator($f, $f, $f, $f),

    MiddlewareResolverInterface::class => fn (ContainerInterface $c) => new ContainerMiddlewareResolver($c),

    App::class => function (NotFoundHandler $defaultHandler, MiddlewareResolverInterface $middlewareResolver) {
        $pipe = require ROOT . 'config/middleware.php';

        return new App($pipe, $defaultHandler, $middlewareResolver);
    },

    ActionResolverInterface::class => fn (ContainerActionResolver $r) => $r,

    ResponseFactoryInterface::class => fn (Psr17Factory $f) => $f,

    EmitterInterface::class => fn (SapiEmitter $e) => $e,

    TemplateRendererInterface::class => function () {
        return new TwigRenderer(new Environment(new FilesystemLoader(ROOT . 'templates')));
    },
];
