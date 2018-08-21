<?php

declare(strict_types=1);

use Sth348962\Algorithms\Permutations\NarayanaAlgorithm;

/**
 * @internal
 */
final class PermutationsTest extends \Codeception\Test\Unit
{
    /**
     * @param callable  $sortFn
     * @param mixed[]   $current  Начальная перестановка
     * @param mixed[][] $expected
     * @dataProvider dataForTestNarayanaAlgorithmSuccess
     */
    public function testNarayanaAlgorithmSuccess(callable $sortFn, array $current, array $expected): void
    {
        $permutations = new NarayanaAlgorithm($sortFn);

        // Получаем все перестановки, начиная с заданной в $current
        $actual = [$current];
        do {
            $current = $permutations->next($current);
            $actual[] = $current;
        } while ($current !== null);
        $this->assertEquals($expected, $actual);
    }

    public function dataForTestNarayanaAlgorithmSuccess(): array
    {
        return [
            // Для пустого массива
            ['__PermutationsTest__eq', [], [[], null]],
            // Для массива из единственного элемента
            ['__PermutationsTest__eq', [1], [[1], null]],
            // Для последней перестановки
            ['__PermutationsTest__eq', [3, 2, 1], [[3, 2, 1], null]],
            // Генерация всех 120 перестановок
            [
                '__PermutationsTest__eq',
                [1, 2, 3, 4, 5],
                [
                    [1, 2, 3, 4, 5],
                    [1, 2, 3, 5, 4],
                    [1, 2, 4, 3, 5],
                    [1, 2, 4, 5, 3],
                    [1, 2, 5, 3, 4],
                    [1, 2, 5, 4, 3],
                    [1, 3, 2, 4, 5],
                    [1, 3, 2, 5, 4],
                    [1, 3, 4, 2, 5],
                    [1, 3, 4, 5, 2],
                    [1, 3, 5, 2, 4],
                    [1, 3, 5, 4, 2],
                    [1, 4, 2, 3, 5],
                    [1, 4, 2, 5, 3],
                    [1, 4, 3, 2, 5],
                    [1, 4, 3, 5, 2],
                    [1, 4, 5, 2, 3],
                    [1, 4, 5, 3, 2],
                    [1, 5, 2, 3, 4],
                    [1, 5, 2, 4, 3],
                    [1, 5, 3, 2, 4],
                    [1, 5, 3, 4, 2],
                    [1, 5, 4, 2, 3],
                    [1, 5, 4, 3, 2],
                    [2, 1, 3, 4, 5],
                    [2, 1, 3, 5, 4],
                    [2, 1, 4, 3, 5],
                    [2, 1, 4, 5, 3],
                    [2, 1, 5, 3, 4],
                    [2, 1, 5, 4, 3],
                    [2, 3, 1, 4, 5],
                    [2, 3, 1, 5, 4],
                    [2, 3, 4, 1, 5],
                    [2, 3, 4, 5, 1],
                    [2, 3, 5, 1, 4],
                    [2, 3, 5, 4, 1],
                    [2, 4, 1, 3, 5],
                    [2, 4, 1, 5, 3],
                    [2, 4, 3, 1, 5],
                    [2, 4, 3, 5, 1],
                    [2, 4, 5, 1, 3],
                    [2, 4, 5, 3, 1],
                    [2, 5, 1, 3, 4],
                    [2, 5, 1, 4, 3],
                    [2, 5, 3, 1, 4],
                    [2, 5, 3, 4, 1],
                    [2, 5, 4, 1, 3],
                    [2, 5, 4, 3, 1],
                    [3, 1, 2, 4, 5],
                    [3, 1, 2, 5, 4],
                    [3, 1, 4, 2, 5],
                    [3, 1, 4, 5, 2],
                    [3, 1, 5, 2, 4],
                    [3, 1, 5, 4, 2],
                    [3, 2, 1, 4, 5],
                    [3, 2, 1, 5, 4],
                    [3, 2, 4, 1, 5],
                    [3, 2, 4, 5, 1],
                    [3, 2, 5, 1, 4],
                    [3, 2, 5, 4, 1],
                    [3, 4, 1, 2, 5],
                    [3, 4, 1, 5, 2],
                    [3, 4, 2, 1, 5],
                    [3, 4, 2, 5, 1],
                    [3, 4, 5, 1, 2],
                    [3, 4, 5, 2, 1],
                    [3, 5, 1, 2, 4],
                    [3, 5, 1, 4, 2],
                    [3, 5, 2, 1, 4],
                    [3, 5, 2, 4, 1],
                    [3, 5, 4, 1, 2],
                    [3, 5, 4, 2, 1],
                    [4, 1, 2, 3, 5],
                    [4, 1, 2, 5, 3],
                    [4, 1, 3, 2, 5],
                    [4, 1, 3, 5, 2],
                    [4, 1, 5, 2, 3],
                    [4, 1, 5, 3, 2],
                    [4, 2, 1, 3, 5],
                    [4, 2, 1, 5, 3],
                    [4, 2, 3, 1, 5],
                    [4, 2, 3, 5, 1],
                    [4, 2, 5, 1, 3],
                    [4, 2, 5, 3, 1],
                    [4, 3, 1, 2, 5],
                    [4, 3, 1, 5, 2],
                    [4, 3, 2, 1, 5],
                    [4, 3, 2, 5, 1],
                    [4, 3, 5, 1, 2],
                    [4, 3, 5, 2, 1],
                    [4, 5, 1, 2, 3],
                    [4, 5, 1, 3, 2],
                    [4, 5, 2, 1, 3],
                    [4, 5, 2, 3, 1],
                    [4, 5, 3, 1, 2],
                    [4, 5, 3, 2, 1],
                    [5, 1, 2, 3, 4],
                    [5, 1, 2, 4, 3],
                    [5, 1, 3, 2, 4],
                    [5, 1, 3, 4, 2],
                    [5, 1, 4, 2, 3],
                    [5, 1, 4, 3, 2],
                    [5, 2, 1, 3, 4],
                    [5, 2, 1, 4, 3],
                    [5, 2, 3, 1, 4],
                    [5, 2, 3, 4, 1],
                    [5, 2, 4, 1, 3],
                    [5, 2, 4, 3, 1],
                    [5, 3, 1, 2, 4],
                    [5, 3, 1, 4, 2],
                    [5, 3, 2, 1, 4],
                    [5, 3, 2, 4, 1],
                    [5, 3, 4, 1, 2],
                    [5, 3, 4, 2, 1],
                    [5, 4, 1, 2, 3],
                    [5, 4, 1, 3, 2],
                    [5, 4, 2, 1, 3],
                    [5, 4, 2, 3, 1],
                    [5, 4, 3, 1, 2],
                    [5, 4, 3, 2, 1],
                    null,
                ],
            ],
        ];
    }

    /**
     * @param callable $sortFn
     * @param mixed[]  $original
     * @dataProvider dataForTestNarayanaAlgorithmFail
     * @expectedException \InvalidArgumentException
     */
    public function testNarayanaAlgorithmFail(callable $sortFn, array $original): void
    {
        $permutations = new NarayanaAlgorithm($sortFn);
        $permutations->next($original);
    }

    public function dataForTestNarayanaAlgorithmFail(): array
    {
        return [
            // Перестановка с одинаковыми элементами
            ['__PermutationsTest__eq', [1, 2, 2]],
        ];
    }
}

function __PermutationsTest__eq($a, $b)
{
    // Сортировка по возрастанию
    return $a <=> $b;
}
