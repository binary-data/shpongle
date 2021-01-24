<?php

declare(strict_types=1);

namespace Binarydata\Shpongle\Console;

use League\Flysystem\Filesystem;
use League\Flysystem\FilesystemException;
use League\Flysystem\Local\LocalFilesystemAdapter;
use Composer\Script\Event;

final class StartProject
{
    private const SHPONGLE_DIR = 'vendor/binarydata/shpongle/src/Console/';

    public static function run(Event $event): void
    {
        $filesystem = new Filesystem(new LocalFilesystemAdapter(
            dirname($event->getComposer()->getConfig()->get('vendor-dir'))
        ));

        if (! $filesystem->fileExists(self::SHPONGLE_DIR . 'index.php')) {
            $event->getIO()->writeError('Error bootstrapping project: custom vendor directory is not supported');
            return;
        }

        try {
            $filesystem->copy(self::SHPONGLE_DIR . 'index_template.php', 'public/index.php');
            $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/di.php');
            $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/middleware.php');
            $filesystem->copy(self::SHPONGLE_DIR . 'config_template.php', 'config/templates.php');
            $filesystem->copy(self::SHPONGLE_DIR . 'routes_template.php', 'config/routes.php');
        } catch (FilesystemException $e) {
            $event->getIO()->writeError('Shpongle bootstrap failed: ' . $e->getMessage());
        }
    }
}
