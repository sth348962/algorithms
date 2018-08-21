<?php

declare(strict_types=1);

namespace Utils;

use Sth348962\Algorithms\Utils\Strings;
use Traversable;

/**
 * @internal
 */
final class StringsTest extends \Codeception\Test\Unit
{
    /**
     * @param string   $ascii
     * @param string[] $expected
     * @dataProvider dataForTestUtf8GeneratorSuccess
     */
    public function testUtf8GeneratorSuccess(string $ascii, array $expected): void
    {
        $actual = Strings::generatorUtf8($ascii);
        $this->assertInstanceOf(Traversable::class, $actual);
        $this->assertEquals($expected, iterator_to_array($actual));
    }

    public function dataForTestUtf8GeneratorSuccess(): array
    {
        return [
            // Пустая строка
            ['', []],
            // ASCII
            ['Hi!', ['H', 'i', '!']],
            // UNICODE
            ['Привет, мир!', ['П', 'р', 'и', 'в', 'е', 'т', ',', ' ', 'м', 'и', 'р', '!']],
            // Разное количество байт
            [
                // 6 байтов
                chr(0b11111100).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000).
                // 5 байтов
                chr(0b11111000).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000).
                // 4 байта
                '🎶'.
                // 3 байта
                '☢'.
                // 2 байта
                'Ф'.
                // 1 байт
                '?',
                // Результат
                [
                    chr(0b11111100).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000),
                    chr(0b11111000).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000),
                    '🎶',
                    '☢',
                    'Ф',
                    '?',
                ],
            ],
        ];
    }

    /**
     * @param string $ascii
     * @dataProvider dataForTestUtf8GeneratorFail
     * @expectedException \InvalidArgumentException
     */
    public function testUtf8GeneratorFail(string $ascii): void
    {
        $iterator = Strings::generatorUtf8($ascii);
        iterator_to_array($iterator);
    }

    public function dataForTestUtf8GeneratorFail(): array
    {
        return [
            // Неверный первый байт
            [
                chr(0b10000000),
            ],
            // Не хватает байтов
            [
                chr(0b11111100).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000),
            ],
            // Неверный второй байт (должен быть 0b10xxxxxx)
            [
                chr(0b11111100).chr(0b11000000).chr(0b10000000).chr(0b10000000).chr(0b10000000).chr(0b10000000),
            ],
        ];
    }
}
