<?php
declare(strict_types=1);

namespace n5s\Brotli\Exception;

use Symfony\Component\Process\Exception\RuntimeException;

final class CorruptInputException extends \InvalidArgumentException implements BrotliException
{
    public static function create(RuntimeException $previous): self
    {
        return new self('Input data is not valid Brotli.', 0, $previous);
    }
}
