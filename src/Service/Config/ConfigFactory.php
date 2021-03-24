<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Service\Config;

use Noodlehaus\Config;

final class ConfigFactory
{
    public function create(): ConfigInterface
    {
        $files = array_filter(
            scandir(ROOT . 'config'),
            fn (string $filename) => preg_match('/\.config\.php$\/i', $filename) === 1
        );

        return new class (new Config($files)) implements ConfigInterface
        {
            public function __construct(private Config $config) {}

            public function get(string $path, $default = null): mixed
            {
                return $this->config->get($path, $default);
            }
        };
    }
}
