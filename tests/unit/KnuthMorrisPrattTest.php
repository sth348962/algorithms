<?php

declare(strict_types=1);

use Sth348962\Algorithms\KnuthMorrisPratt\KnuthMorrisPratt;
use Sth348962\Algorithms\KnuthMorrisPratt\PrefixFunction;

/**
 * @internal
 */
final class KnuthMorrisPrattTest extends \Codeception\Test\Unit
{
    /**
     * @param int[]  $expected Массив с позициями подстроки
     * @param string $text     Текст, в котором осуществляется поиск
     * @param string $sample   Искомый текст
     * @param int[]  $p        Значение префикс-функции
     * @dataProvider dataForTestSubstringPositions
     */
    public function testSubstringPositions($expected, $text, $sample, $p): void
    {
        $kmp = new KnuthMorrisPratt();
        $this->assertEquals($expected, $kmp->positions($text, $sample, $p));
    }

    public function dataForTestSubstringPositions(): array
    {
        return [
            [[0, 3, 8, 11], 'aabaabaaaabaabaaab', 'aabaa', [0, 1, 0, 1, 2]],
            [[15], 'abcxabcdabxabcdabcdabcy', 'abcdabcy', [0, 0, 0, 0, 1, 2, 3, 0]],
        ];
    }

    /**
     * @param int[]  $expected Ожидаемой значение префикс функции
     * @param string $for      Строка
     * @dataProvider dataForTestPrefixFunction
     */
    public function testPrefixFunction($expected, $for): void
    {
        $prefixFunction = new PrefixFunction();
        $this->assertEquals($expected, $prefixFunction->get($for));
    }

    public function dataForTestPrefixFunction(): array
    {
        return [
            [[0, 1, 0, 1, 2], 'aabaa'],
            [[0, 0, 0, 0, 1, 2, 3, 0], 'abcdabcy'],
            [[0, 0, 0, 1, 0, 1, 2, 3, 4, 2], 'abcacabcab'],
            [[0, 0, 0, 0, 1, 2, 0, 0, 1, 2, 3, 4, 5, 6, 0, 1], 'abcdabscabcdabia'],
        ];
    }
}
