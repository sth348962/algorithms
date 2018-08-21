<?php

declare(strict_types=1);

use Sth348962\Algorithms\LevenshteinDistance\Backtrace;
use Sth348962\Algorithms\LevenshteinDistance\Backtrace\Step;
use Sth348962\Algorithms\LevenshteinDistance\WagnerFischer;
use Tree\Visitor\PreOrderVisitor;

/**
 * @internal
 */
final class LevenshteinDistanceTest extends \Codeception\Test\Unit
{
    /**
     * @param int[][] $expected Матрица дистанций
     * @param string  $from     Из какой строки
     * @param string  $to       В какую строку
     * @dataProvider dataForTestDistance
     */
    public function testDistance(array $expected, string $from, string $to): void
    {
        $distance = new WagnerFischer();
        $this->assertEquals($expected, $distance->matrix($from, $to));
    }

    public function dataForTestDistance(): array
    {
        return [
            [[], '', ''],
            [[
                [0, 1, 2, 3, 4, 5, 6, 7],
            ], '', 'connect'],
            [[
                [0],
                [1],
                [2],
                [3],
                [4],
                [5],
                [6],
                [7],
                [8],
            ], 'conehead', ''],
            [[
                [0, 1],
                [1, 1],
            ], 'b', 'a'],
            [[
                [0, 1, 2, 3, 4, 5, 6],
                [1, 1, 2, 2, 3, 4, 5],
                [2, 2, 2, 3, 2, 3, 4],
            ], 'cd', 'abcdef'],
            [[
                [0, 1, 2, 3, 4],
                [1, 0, 1, 2, 3],
                [2, 1, 0, 1, 2],
                [3, 2, 1, 0, 1],
            ], 'con', 'conn'],
            [[
                [0, 1, 2, 3, 4, 5, 6, 7],
                [1, 0, 1, 2, 3, 4, 5, 6],
                [2, 1, 0, 1, 2, 3, 4, 5],
                [3, 2, 1, 0, 1, 2, 3, 4],
                [4, 3, 2, 1, 1, 1, 2, 3],
                [5, 4, 3, 2, 2, 2, 2, 3],
                [6, 5, 4, 3, 3, 2, 3, 3],
                [7, 6, 5, 4, 4, 3, 3, 4],
                [8, 7, 6, 5, 5, 4, 4, 4],
            ], 'conehead', 'connect'],
            [[
                [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [1, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [2, 2, 2, 3, 4, 5, 6, 7, 8, 9, 10],
                [3, 2, 3, 3, 4, 5, 6, 7, 8, 9, 10],
                [4, 3, 2, 3, 4, 5, 5, 6, 7, 8, 9],
                [5, 4, 3, 3, 4, 4, 5, 6, 7, 8, 9],
                [6, 5, 4, 4, 4, 5, 5, 6, 7, 8, 9],
                [7, 6, 5, 5, 5, 4, 5, 6, 7, 8, 9],
                [8, 7, 6, 6, 6, 5, 5, 6, 7, 8, 9],
                [9, 8, 7, 7, 7, 6, 6, 6, 6, 7, 8],
                [10, 9, 8, 8, 8, 7, 7, 7, 7, 6, 7],
                [11, 10, 9, 8, 9, 8, 8, 8, 8, 7, 6],
            ], 'exponential', 'polynomial'],
        ];
    }

    /**
     * @param \Sth348962\Algorithms\LevenshteinDistance\Backtrace\Step[][] $expected Массив редакционных путей
     * @param string                                                       $from     Из какой строки
     * @param string                                                       $to       В какую строку
     * @param int[][]                                                      $matrix   Матрица дистанций
     * @dataProvider dataForTestBacktrace
     */
    public function testBacktrace(array $expected, string $from, string $to, array $matrix): void
    {
        $backtrace = new Backtrace();
        $root = $backtrace->root($from, $to, $matrix);

        // Получаем массив редакционных путей
        $visitor = new PreOrderVisitor();
        $paths = array_map(function ($node) {
            return $node->getValue();
        }, $visitor->visit($root));

        // Сверяем с ожиданиями
        $this->assertEquals($expected, $paths);
    }

    public function dataForTestBacktrace(): array
    {
        return [
            // case #0
            [
                [
                    Step::root(),
                ], '', '', [],
            ],
            // case #1
            [
                [
                    Step::root(),
                    Step::insert('t', 7, 0),
                    Step::insert('c', 6, 0),
                    Step::insert('e', 5, 0),
                    Step::insert('n', 4, 0),
                    Step::insert('n', 3, 0),
                    Step::insert('o', 2, 0),
                    Step::insert('c', 1, 0),
                ], '', 'connect', [[0, 1, 2, 3, 4, 5, 6, 7]],
            ],
            // case #2
            [
                [
                    Step::root(),
                    Step::delete('d', 0, 8),
                    Step::delete('a', 0, 7),
                    Step::delete('e', 0, 6),
                    Step::delete('h', 0, 5),
                    Step::delete('e', 0, 4),
                    Step::delete('n', 0, 3),
                    Step::delete('o', 0, 2),
                    Step::delete('c', 0, 1),
                ], 'conehead', '', [[0], [1], [2], [3], [4], [5], [6], [7], [8]],
            ],
            // case #3
            [
                [
                    Step::root(),
                    Step::replace('b', 'a', 1, 1),
                ], 'b', 'a', [[0, 1], [1, 1]],
            ],
            // case #4
            [
                [
                    Step::root(),
                    Step::insert('n', 4, 3),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),
                ],
                'con',
                'conn',
                [
                    [0, 1, 2, 3, 4],
                    [1, 0, 1, 2, 3],
                    [2, 1, 0, 1, 2],
                    [3, 2, 1, 0, 1],
                ],
            ],
            // case #5
            [
                [
                    Step::root(),

                    // Путь #0
                    Step::replace('d', 't', 7, 8),
                    Step::replace('a', 'c', 6, 7),
                    Step::match('e', 5, 6),
                    Step::replace('h', 'n', 4, 5),
                    Step::delete('e', 3, 4),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),

                    // Путь #1
                    Step::delete('h', 4, 5),
                    Step::replace('e', 'n', 4, 4),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),

                    // Путь #2
                    Step::delete('e', 5, 6),
                    Step::replace('h', 'e', 5, 5),
                    Step::replace('e', 'n', 4, 4),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),

                    // Путь #3
                    Step::delete('h', 5, 5),
                    Step::match('e', 5, 4),
                    Step::insert('n', 4, 3),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),

                    // Путь #4
                    Step::insert('e', 5, 4),
                    Step::replace('e', 'n', 4, 4),
                    Step::match('n', 3, 3),
                    Step::match('o', 2, 2),
                    Step::match('c', 1, 1),
                ],
                'conehead',
                'connect',
                [
                    [0, 1, 2, 3, 4, 5, 6, 7],
                    [1, 0, 1, 2, 3, 4, 5, 6],
                    [2, 1, 0, 1, 2, 3, 4, 5],
                    [3, 2, 1, 0, 1, 2, 3, 4],
                    [4, 3, 2, 1, 1, 1, 2, 3],
                    [5, 4, 3, 2, 2, 2, 2, 3],
                    [6, 5, 4, 3, 3, 2, 3, 3],
                    [7, 6, 5, 4, 4, 3, 3, 4],
                    [8, 7, 6, 5, 5, 4, 4, 4],
                ],
            ],
            // case #7
            [
                [
                    Step::root(),

                    // Путь #0
                    Step::insert('f', 6, 2),
                    Step::insert('e', 5, 2),
                    Step::match('d', 4, 2),
                    Step::match('c', 3, 1),
                    Step::insert('b', 2, 0),
                    Step::insert('a', 1, 0),

                    // Путь #1
                    Step::insert('c', 3, 1),
                    Step::replace('c', 'b', 2, 1),
                    Step::insert('a', 1, 0),

                    // Путь #2
                    Step::insert('b', 2, 1),
                    Step::replace('c', 'a', 1, 1),
                ],
                'cd',
                'abcdef',
                [
                    [0, 1, 2, 3, 4, 5, 6],
                    [1, 1, 2, 2, 3, 4, 5],
                    [2, 2, 2, 3, 2, 3, 4],
                ],
            ],
        ];
    }
}
