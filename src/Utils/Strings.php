<?php

namespace Sth348962\Algorithms\Utils;

use InvalidArgumentException;
use Traversable;

class Strings
{
    /**
     * Возвращает генератор для прохождения строки в кодировке UTF8 символ за символом.
     *
     * @param string $string
     * @return \Traversable
     */
    public function generatorUtf8(string $string): Traversable
    {
        return (function () use ($string) {
            $len = strlen($string);
            for ($i = 0; $i < $len; $i++) {
                $v = ord($string[$i]);

                // | Number of bytes | Bits for code point | First code point | Last code point | Byte 1   | Byte 2   | Byte 3   | Byte 4   | Byte 5   | Byte 6   |
                // |-----------------|---------------------|------------------|-----------------|----------|----------|----------|----------|----------|----------|
                // | 1               | 7                   | U+0000           | U+007F          | 0xxxxxxx |          |          |          |          |          |
                // | 2               | 11                  | U+0080           | U+07FF          | 110xxxxx | 10xxxxxx |          |          |          |          |
                // | 3               | 16                  | U+0800           | U+FFFF          | 1110xxxx | 10xxxxxx | 10xxxxxx |          |          |          |
                // | 4               | 21                  | U+10000          | U+1FFFFF        | 11110xxx | 10xxxxxx | 10xxxxxx | 10xxxxxx |          |          |
                // | 5               | 26                  | U+200000         | U+3FFFFFF       | 111110xx | 10xxxxxx | 10xxxxxx | 10xxxxxx | 10xxxxxx |          |
                // | 6               | 31                  | U+4000000        | U+7FFFFFFF      | 1111110x | 10xxxxxx | 10xxxxxx | 10xxxxxx | 10xxxxxx | 10xxxxxx |
                if ($v < 0b10000000) {
                    yield $string[$i];
                    continue;
                }

                if ($v < 0b11000000) {
                    throw new InvalidArgumentException('string in a wrong format');
                }

                if ($v < 0b11100000) {
                    $bytes = 2;
                } else if ($v < 0b11110000) {
                    $bytes = 3;
                } else if ($v < 0b11111000) {
                    $bytes = 4;
                } else if ($v < 0b11111100) {
                    $bytes = 5;
                } else {
                    $bytes = 6;
                }

                yield substr($string, $i, 2);
                $i = $i + $bytes - 1;
            }
        })();
    }
}