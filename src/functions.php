<?php

declare(strict_types=1);
use n5s\Brotli\Brotli;
use n5s\Brotli\Exception\BrotliException;
use Symfony\Component\Process\Exception\ExceptionInterface;

if (! function_exists('brotli_compress') && ! function_exists('brotli_uncompress')) {
    /**
     * @param string $data The raw data to compress
     * @param int<0, 11> $quality Compression level (0-11)
     * @return string The compressed data
     * @throws BrotliException If quality is invalid
     * @throws ExceptionInterface In case something went wrong with process
     */
    function brotli_compress(string $data, int $quality = 11): string
    {
        return Brotli::compress($data, $quality);
    }

    /**
     * @param string $data The compressed data
     * @return string The uncompressed data
     * @throws BrotliException If data is not valid Brotli
     * @throws ExceptionInterface In case something went wrong with process
     */
    function brotli_uncompress(string $data): string
    {
        return Brotli::uncompress($data);
    }
}
