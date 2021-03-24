<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Service\Config;

interface ConfigInterface
{
    /**
     * @param string $path
     * @param mixed|null $default
     * @return mixed
     */
    public function get(string $path, $default = null): mixed;
}
