<?php

declare(strict_types=1);

use Sth348962\Algorithms\ZFunction\ZFunction;

/**
 * @internal
 */
final class ZFunctionTest extends \Codeception\Test\Unit
{
    /**
     * @param int[]  $expected Ожидаемой значение z-функции
     * @param string $for      Строка
     * @dataProvider dataForTestZFunction
     */
    public function testZFunction($expected, $for): void
    {
        $zFunction = new ZFunction();
        $this->assertEquals($expected, $zFunction->get($for));
    }

    public function dataForTestZFunction(): array
    {
        return [
            [[0], ''],
            [[1], 'a'],
            [[16, 0, 0, 0, 2, 0, 0, 0, 6, 0, 0, 0, 2, 0, 0, 1], 'abcdabscabcdabia'],
            [[10, 0, 8, 0, 6, 0, 4, 0, 2, 0], 'ababababab'],
            [[10, 1, 0, 0, 2, 1, 0, 3, 1, 0], 'aabxaayaab'],
            [[19, 1, 0, 0, 4, 1, 0, 0, 0, 8, 1, 0, 0, 5, 1, 0, 0, 1, 0], 'aabxaabxcaabxaabxay'],
        ];
    }
}
