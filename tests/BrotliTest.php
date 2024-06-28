<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use n5s\Brotli\Brotli;

final class BrotliTest extends TestCase
{
    /**
     * @dataProvider compressDataProvider
     */
    public function testCompressAndUncompressWithAllQualities(int $quality, bool $useFunctions)
    {
        $data = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus.';

        $compressed = $useFunctions ? brotli_compress($data, $quality) : Brotli::compress($data, $quality);

        $this->assertNotSame($data, $compressed);

        $uncompressed = $useFunctions ? brotli_uncompress($compressed) : Brotli::uncompress($compressed);

        $this->assertSame($data, $uncompressed);
    }

    public function compressDataProvider()
    {
        return [
            [0,     false],
            [0,     true],
            [1,     false],
            [1,     true],
            [2,     false],
            [2,     true],
            [3,     false],
            [3,     true],
            [4,     false],
            [4,     true],
            [5,     false],
            [5,     true],
            [6,     false],
            [6,     true],
            [7,     false],
            [7,     true],
            [8,     false],
            [8,     true],
            [9,     false],
            [9,     true],
            [10,    false],
            [10,    true],
            [11,    false],
            [11,    true],
        ];
    }

    public function testDecodeNonBrotliData()
    {
        $this->expectException(\n5s\Brotli\Exception\CorruptInputException::class);
        $this->expectExceptionMessage('Input data is not valid Brotli.');

        Brotli::uncompress('this is not brotli');
    }

    public function testCompressAndUncompressEmptyString()
    {
        $this->assertSame('', Brotli::uncompress(Brotli::compress('')));
    }

    /**
     * @dataProvider invalidQualityDataProvider
     */
    public function testInvalidQuality(int $quality)
    {
        $this->expectException(\n5s\Brotli\Exception\InvalidQualityException::class);
        $this->expectExceptionMessageMatches('#^The quality value is invalid#');

        $this->expectExceptionMessage('The quality value is invalid. Must be between 0 and 11, '.$quality.' given.');
        Brotli::compress('hello', $quality);
    }

    public function invalidQualityDataProvider()
    {
        return [
            [-1],
            [12],
        ];
    }
}
