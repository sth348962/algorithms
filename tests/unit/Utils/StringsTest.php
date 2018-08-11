<?php

namespace Utils;

use Traversable;

use Sth348962\Algorithms\Utils\Strings;

class StringsTest extends \Codeception\Test\Unit
{
    /**
     * @param string $ascii
     * @param string[] $expected
     * @dataProvider dataForTestUtf8
     */
    public function testUtf8Generator(string $ascii, array $expected)
    {
        $actual = Strings::generatorUtf8($ascii);
        $this->assertInstanceOf(Traversable::class, $actual);
        $this->assertEquals($expected, iterator_to_array($actual));
    }

    public function dataForTestUtf8()
    {
        return [
            // Пустая строка
            ['', []],
            // ASCII
            ['Hi!', ['H', 'i', '!']],
            // UNICODE
            ['Привет, мир!', ['П', 'р', 'и', 'в', 'е', 'т', ',', ' ', 'м', 'и', 'р', '!']],
            ['Kąt ï»¿', ['K', 'ą', 't', ' ', 'ï', '»', '¿']],
        ];
    }
}