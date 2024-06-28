<?php
declare(strict_types=1);

namespace n5s\Brotli;

use Symfony\Component\Process\Exception\ExceptionInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use n5s\Brotli\Exception\BrotliException;
use n5s\Brotli\Exception\CorruptInputException;
use n5s\Brotli\Exception\InvalidQualityException;
use n5s\LocalBin\Binary\Brotli as BinaryBrotli;

final class Brotli
{
    /**
     * @param string $data The raw data to compress
     * @param int $quality Compression level (0-11)
     * @return string The compressed data
     * @throws BrotliException If quality is invalid
     * @throws ExceptionInterface In case something went wrong with process
     */
    public static function compress(string $data, int $quality = 11): string
    {
        if ($quality < 0 || $quality > 11) {
            throw InvalidQualityException::create($quality);
        }

        return self::runBinary(['-q', $quality], $data);
    }

    /**
     * @param string $data The compressed data
     * @return string The uncompressed data
     * @throws BrotliException If data is not valid Brotli
     * @throws ExceptionInterface In case something went wrong with process
     */
    public static function uncompress(string $data): string
    {
        return self::runBinary(['-d'], $data);
    }

    private static function runBinary(array $arguments, string $stdin): string
    {
        $brotli = BinaryBrotli::getPath();
        array_unshift($arguments, $brotli);
        $proc = new Process($arguments, null, null, $stdin);

        try {
            $proc->mustRun();
        } catch (ProcessFailedException $exception) {
            if (strpos($proc->getErrorOutput(), 'corrupt input') === 0) {
                throw CorruptInputException::create($exception);
            }

            throw $exception;
        }

        return $proc->getOutput();
    }
}
