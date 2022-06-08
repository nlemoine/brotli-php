<?php

namespace HelloNico\Brotli;

class Process extends \Symfony\Component\Process\Process
{
    private static $sigchild;

    /**
     * Returns whether PHP has been compiled with the '--enable-sigchild' option or not.
     *
     * @return bool
     */
    protected function isSigchildEnabled(): bool
    {
        if (null !== self::$sigchild) {
            return self::$sigchild;
        }

        if (!\function_exists('phpinfo')) {
            return self::$sigchild = false;
        }

        return self::$sigchild = false !== strpos(shell_exec('php -i'), '--enable-sigchild');
    }
}
