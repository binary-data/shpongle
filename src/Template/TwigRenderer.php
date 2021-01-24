<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Template;

use Nyholm\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use Twig\Environment;

class TwigRenderer implements TemplateRendererInterface
{
    public function __construct(private Environment $twig) {}

    public function render(string $name, array $context): StreamInterface
    {
        return Stream::create($this->twig->render($name, $context));
    }
}
