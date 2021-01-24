<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Template;

use RuntimeException;

final class TwigTemplateFinder
{
    public function find(string $actionName): string
    {
        $templates = require ROOT . 'config/templates.php';

        $template = $templates[$actionName] ?? null;

        if ($template === null) {
            throw new RuntimeException("template for action '$actionName' not found");
        }

        return $template;
    }
}
