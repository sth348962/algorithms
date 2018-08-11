<?php

namespace Sth348962\Algorithms\Utils;

use InvalidArgumentException;
use Traversable;

class Strings
{
    /**
     * Возвращает генератор для прохождения строки в кодировке UTF-8 символ за символом.
     *
     * @param string $string
     * @return \Traversable
     * @throws \InvalidArgumentException Если строка не в UTF-8
     */
    public function generatorUtf8(string $string): Traversable
    {
        return (function () use ($string) {
            $len = strlen($string);
            for ($i = 0; $i < $len; $i++) {
                $v = ord($string[$i]);

                // Таблица из [Википедии](https://en.wikipedia.org/wiki/UTF-8)
                //
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
                    $additional = 1;
                } else if ($v < 0b11110000) {
                    $additional = 2;
                } else if ($v < 0b11111000) {
                    $additional = 3;
                } else if ($v < 0b11111100) {
                    $additional = 4;
                } else {
                    $additional = 5;
                }

                $result = $string[$i];
                while ($additional--) {
                    $i++;
                    if ($i === $len) {
                        // Если в строке не хватает байтов
                        throw new InvalidArgumentException('string in a wrong format');
                    }

                    // Значение байта должно находиться в пределах 10xxxxxx
                    $v = ord($string[$i]);
                    if ($v < 0b10000000 || $v > 0b10111111) {
                        throw new InvalidArgumentException('string in a wrong format');
                    }

                    $result = $result . $string[$i];
                }
                yield $result;
            }
        })();
    }
}