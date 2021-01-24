<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Template;

use Psr\Http\Message\StreamInterface;

interface TemplateRendererInterface
{
    /**
     * @param string $name
     * @param mixed[] $context
     * @return StreamInterface
     */
    public function render(string $name, array $context): StreamInterface;
}
