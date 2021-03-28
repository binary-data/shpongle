<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Http\Middleware;

use Binarydata\Shpongle\Http\RequestAttribute;
use Binarydata\Shpongle\Template\TemplateRendererInterface;
use Binarydata\Shpongle\Template\TwigTemplateFinder;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class TemplateRendererMiddleware implements MiddlewareInterface
{
    public function __construct(
        private TemplateRendererInterface $renderer,
        private ResponseFactoryInterface $responseFactory,
        private TwigTemplateFinder $templateFinder
    ) {}

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse()
            ->withBody(
                $this->renderer->render(
                    $this->templateFinder->find($request->getAttribute(RequestAttribute::ACTION_CLASS)),
                    $request->getAttribute(RequestAttribute::RESPONSE_VARS),
                )
            );
    }
}
