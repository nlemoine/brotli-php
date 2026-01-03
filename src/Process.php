<?php

declare(strict_types=1);

namespace n5s\Brotli;

use Symfony\Component\Process\Process as SymfonyProcess;

class Process extends SymfonyProcess
{
    private static bool $sigchild;

    /**
     * Returns whether PHP has been compiled with the '--enable-sigchild' option or not.
     */
    protected function isSigchildEnabled(): bool
    {
        if (isset(self::$sigchild)) {
            return self::$sigchild;
        }

        if (! \function_exists('phpinfo')) {
            return self::$sigchild = false;
        }

        return self::$sigchild = str_contains((string) shell_exec('php -i'), '--enable-sigchild');
    }
}
