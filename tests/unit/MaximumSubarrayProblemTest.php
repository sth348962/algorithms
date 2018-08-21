<?php

declare(strict_types=1);

use Sth348962\Algorithms\MaximumSubarrayProblem\DivideAndConquer;
use Sth348962\Algorithms\MaximumSubarrayProblem\Kadane;
use Sth348962\Algorithms\MaximumSubarrayProblem\Result;
use Sth348962\Algorithms\MaximumSubarrayProblem\Subarray;

/**
 * @internal
 */
final class MaximumSubarrayProblemTest extends \Codeception\Test\Unit
{
    /**
     * @param int[]                                               $original       Массив целый чисел, в котором происходит поиск
     * @param \Sth348962\Algorithms\MaximumSubarrayProblem\Result $expectedResult Результаты поиска
     * @dataProvider dataForTests
     */
    public function testDivideAndConquer(array $original, Result $expectedResult): void
    {
        $solution = new DivideAndConquer();
        $actualResult = $solution->find($original, 0, count($original) - 1);
        $this->assertEquals($expectedResult->sum, $actualResult->sum);
        // Сравнение массивов игнорируя порядок элементов
        $this->assertEquals(count($expectedResult->subarrays), count($actualResult->subarrays));
        $this->assertEmpty(array_diff($expectedResult->subarrays, $actualResult->subarrays));
    }

    /**
     * @param int[]                                               $original       Массив целый чисел, в котором происходит поиск
     * @param \Sth348962\Algorithms\MaximumSubarrayProblem\Result $expectedResult Результаты поиска
     * @dataProvider dataForTests
     */
    public function testKadane(array $original, Result $expectedResult): void
    {
        $solution = new Kadane();
        $actualResult = $solution->find($original, 0, count($original) - 1);
        $this->assertEquals($expectedResult->sum, $actualResult->sum);
        // Сравнение массивов игнорируя порядок элементов
        $this->assertEquals(count($expectedResult->subarrays), count($actualResult->subarrays));
        $this->assertEmpty(array_diff($expectedResult->subarrays, $actualResult->subarrays));
    }

    public function dataForTests(): array
    {
        return [
            [
                [-25],
                new Result(-25, [
                    new Subarray(0, 1),
                ]),
            ],
            [
                [-25, -25],
                new Result(-25, [
                    new Subarray(0, 1),
                    new Subarray(1, 1),
                ]),
            ],
            [
                [-25, -30],
                new Result(-25, [
                    new Subarray(0, 1),
                ]),
            ],
            [
                [-25, -20],
                new Result(-20, [
                    new Subarray(1, 1),
                ]),
            ],
            [
                [25, 20],
                new Result(45, [
                    new Subarray(0, 2),
                ]),
            ],
            [
                [-2, 1, -3, 4, -1, 1, 2, -5, 4],
                new Result(6, [
                    new Subarray(3, 4),
                ]),
            ],
            [
                [5, -5, 5, -5, 5, -5, 5],
                new Result(5, [
                    new Subarray(0, 1),
                    new Subarray(0, 3),
                    new Subarray(0, 5),
                    new Subarray(0, 7),
                    new Subarray(2, 1),
                    new Subarray(2, 3),
                    new Subarray(2, 5),
                    new Subarray(4, 1),
                    new Subarray(4, 3),
                    new Subarray(6, 1),
                ]),
            ],
            [
                [0, 25, -10, -5, -5, -5, 25, -10, -5, -5, -5, 0, 25, -10, -5, -5, -5, 25],
                new Result(25, [
                    new Subarray(1, 1),
                    new Subarray(0, 2),
                    new Subarray(6, 1),
                    new Subarray(1, 6),
                    new Subarray(0, 7),
                    new Subarray(12, 1),
                    new Subarray(11, 2),
                    new Subarray(17, 1),
                    new Subarray(12, 6),
                    new Subarray(11, 7),
                    new Subarray(6, 7),
                    new Subarray(6, 12),
                    new Subarray(1, 12),
                    new Subarray(1, 17),
                    new Subarray(0, 13),
                    new Subarray(0, 18),
                ]),
            ],
        ];
    }
}
