<?php

/** @noinspection PhpUnhandledExceptionInspection */

declare(strict_types=1);

namespace Binarydata\Shpongle\Console;

use League\Flysystem\Filesystem;
use League\Flysystem\Local\LocalFilesystemAdapter;
use RuntimeException;

final class CreateProject
{
    private const SHPONGLE_DIR = '/vendor/binarydata/shpongle/src/Console/';

    public function run(): void
    {
        $filesystem = new Filesystem(new LocalFilesystemAdapter(ROOT));

        if ($filesystem->fileExists('public/index.php')) {
            throw new RuntimeException('Project was already created');
        }

        if (! $filesystem->fileExists(self::SHPONGLE_DIR . 'index_template.php')) {
            throw new RuntimeException('Error bootstrapping project: custom bin directory is not supported');
        }

        $filesystem->copy(self::SHPONGLE_DIR . 'index_template.php', 'public/index.php');
        $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/di.php');
        $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/middleware.php');
        $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/templates.php');
        $filesystem->copy(self::SHPONGLE_DIR . 'routes_template.php', 'config/routes.php');
    }
}
