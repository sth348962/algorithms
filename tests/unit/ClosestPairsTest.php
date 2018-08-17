<?php

declare(strict_types=1);

use Sth348962\Algorithms\ClosestPair\Space2D;
use Sth348962\Algorithms\Sorters\MergeSorter;
use Sth348962\Algorithms\Utils\Point2D;

/**
 * @internal
 * @coversNothing
 */
final class ClosestPairsTest extends \Codeception\Test\Unit
{
    /**
     * @param mixed[][] $expected Пары точек с минимальным расстоянием
     * @param int[][]   $points   Координаты (x, y) точек
     * @dataProvider dataForTestFindClosestPairsInSpace2D
     */
    public function testFindClosestPairsInSpace2D(array $expected, array $points): void
    {
        $xMergeSorter = new MergeSorter('__ClosestPairsTest__eq__X');
        $yMergeSorter = new MergeSorter('__ClosestPairsTest__eq__Y');

        $closestPairs = new Space2D(
            '__ClosestPairsTest__eq__X',
            '__ClosestPairsTest__eq__Y',
            [$xMergeSorter, 'sort'],
            [$yMergeSorter, 'sort'],
            [$yMergeSorter, 'merge'],
            '__ClosestPairsTest__measure',
            '__ClosestPairsTest__measureX',
            '__ClosestPairsTest__measureY'
        );

        $this->assertEquals($expected, $closestPairs->find($points));
    }

    public function dataForTestFindClosestPairsInSpace2D(): array
    {
        return [
            [
                [[new Point2D(1, 2), new Point2D(2, 3)], [new Point2D(2, 3), new Point2D(3, 4)]],
                [new Point2D(2, 3), new Point2D(3, 4), new Point2D(1, 2)],
            ],
            [
                [[new Point2D(1, 2), new Point2D(2, 3)], [new Point2D(2, 3), new Point2D(3, 4)]],
                [new Point2D(2, 3), new Point2D(12, 30), new Point2D(40, 50), new Point2D(5, 1), new Point2D(12, 10), new Point2D(3, 4), new Point2D(1, 2)],
            ],
            [
                // Пара точек из двух разных половин
                [[new Point2D(7, 3), new Point2D(8, 2)], [new Point2D(5, 6), new Point2D(4, 7)]],
                [new Point2D(1, 2), new Point2D(3, 4), new Point2D(4, 7), new Point2D(5, 6), new Point2D(7, 3), new Point2D(8, 2)],
            ],
        ];
    }
}

function __ClosestPairsTest__measure(Point2D $a, Point2D $b): float
{
    // Расстояние между точками
    return $a->distance($b);
}

function __ClosestPairsTest__measureX(Point2D $a, Point2D $b): float
{
    // Расстояние между точками по координате x
    return sqrt(($a->getX() - $b->getX()) ** 2);
}

function __ClosestPairsTest__measureY(Point2D $a, Point2D $b): float
{
    // Расстояние между точками по координате y
    return sqrt(($a->getY() - $b->getY()) ** 2);
}

function __ClosestPairsTest__eq__X(Point2D $a, Point2D $b): int
{
    // Сортировка по возрастанию координаты X
    return $a->compareX($b);
}

function __ClosestPairsTest__eq__Y(Point2D $a, Point2D $b): int
{
    // Сортировка по возрастанию координаты Y
    return $a->compareY($b);
}
