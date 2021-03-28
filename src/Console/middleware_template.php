<?php

declare(strict_types=1);

use Binarydata\Shpongle\Http\Middleware\ActionDispatcherMiddleware;
use Binarydata\Shpongle\Http\Middleware\RouterMiddleware;
use Binarydata\Shpongle\Http\Route\RouteCollectionInterface;

return [
    RouteCollectionInterface::GROUP_DEFAULT => [

        /**
         * Core middlewares, required so the framework can work.
         * Must be present in default group, if you wish to preserve default behavior.
         *
         * You may add custom middleware here as well.
         */

        RouterMiddleware::class,
        ActionDispatcherMiddleware::class,
    ],

    /** Add custom groups below. Will be executed after the 'default' group.  */

    //'myCustomApiGroup' => [
    //    \Me\MyAwesomeApp\Middleware\CustomApiMiddleware::class,
    //    \Me\MyAwesomeApp\Middleware\AnotherCustomApiMiddleware::class,
    //],
];
