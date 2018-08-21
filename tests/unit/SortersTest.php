<?php

declare(strict_types=1);

use Sth348962\Algorithms\Sorters\InsertionSorter;
use Sth348962\Algorithms\Sorters\MergeSorter;
use Sth348962\Algorithms\Sorters\QuickSorter;

/**
 * @internal
 */
final class SortersTest extends \Codeception\Test\Unit
{
    /**
     * @param mixed[]  $original
     * @param callable $sortFn
     * @dataProvider dataForTestInsertionSorterSort
     */
    public function testInsertionSorterSort(array $original, callable $sortFn): void
    {
        $expected = $original;
        $this->assertTrue(usort($expected, $sortFn));

        $sorter = new InsertionSorter($sortFn);
        $this->assertEquals($expected, $sorter->sort($original));
    }

    public function dataForTestInsertionSorterSort(): array
    {
        return [
            [[], '__SortersTest__eq'],
            [[1], '__SortersTest__eq'],
            [[3, 2], '__SortersTest__eq'],
            [[100, 54, 1, 7, 4, 2, 5, 4, 1], '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $original
     * @param callable $sortFn
     * @dataProvider dataForTestQuickSorterSort
     */
    public function testQuickSorterSort(array $original, callable $sortFn): void
    {
        $expected = $original;
        $this->assertTrue(usort($expected, $sortFn));

        $sorter = new QuickSorter($sortFn);
        $this->assertEquals($expected, $sorter->sort($original));
    }

    public function dataForTestQuickSorterSort(): array
    {
        return [
            [[], '__SortersTest__eq'],
            [[1], '__SortersTest__eq'],
            [[3, 2], '__SortersTest__eq'],
            [[100, 54, 1, 7, 4, 2, 5, 4, 1], '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $original
     * @param callable $sortFn
     * @dataProvider dataForTestQuickSorterMSortUsingLomutoPartition
     */
    public function testQuickSorterMSortUsingLomutoPartition(array $original, callable $sortFn): void
    {
        $expected = $original;
        $this->assertTrue(usort($expected, $sortFn));
        $sorter = new QuickSorter($sortFn);
        $this->assertTrue($sorter->mSortUsingLomutoPartition($original, 0, count($original) - 1));

        $this->assertEquals($expected, $original);
    }

    public function dataForTestQuickSorterMSortUsingLomutoPartition(): array
    {
        return [
            [[], '__SortersTest__eq'],
            [[1], '__SortersTest__eq'],
            [[3, 2], '__SortersTest__eq'],
            [[100, 54, 1, 7, 4, 2, 5, 4, 1], '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $original
     * @param callable $sortFn
     * @dataProvider dataForTestQuickSorterMSortUsingHoarePartition
     */
    public function testQuickSorterMSortUsingHoarePartition(array $original, callable $sortFn): void
    {
        $expected = $original;
        $this->assertTrue(usort($expected, $sortFn));
        $sorter = new QuickSorter($sortFn);
        $this->assertTrue($sorter->mSortUsingHoarePartition($original, 0, count($original) - 1));

        $this->assertEquals($expected, $original);
    }

    public function dataForTestQuickSorterMSortUsingHoarePartition(): array
    {
        return [
            [[], '__SortersTest__eq'],
            [[1], '__SortersTest__eq'],
            [[3, 2], '__SortersTest__eq'],
            [[100, 54, 1, 7, 4, 2, 5, 4, 1], '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $expected
     * @param mixed[]  $original
     * @param int      $expectedPivot Позиция опорного элемента после упорядочивания массива
     * @param int      $lo            Нижний индекс
     * @param int      $hi            Верхний индекс
     * @param callable $sortFn
     * @dataProvider dataForTestQuickSorterLomutoPartition
     */
    public function testQuickSorterLomutoPartition(array $expected, int $expectedPivot, array $original, int $lo, int $hi, callable $sortFn): void
    {
        $sorter = new QuickSorter($sortFn);
        $this->assertEquals($expectedPivot, $sorter->lomutoPartition($original, $lo, $hi));
        $this->assertEquals($expected, $original);
    }

    public function dataForTestQuickSorterLomutoPartition(): array
    {
        return [
            [[], 0, [], 0, 0, '__SortersTest__eq'],
            [[1], 0, [1], 0, 0, '__SortersTest__eq'],
            [[1, 2], 0, [2, 1], 0, 1, '__SortersTest__eq'],
            [[1, 54, 1, 7, 4, 2, 5, 4, 100], 0, [100, 54, 1, 7, 4, 2, 5, 4, 1], 0, 8, '__SortersTest__eq'],
            [[100, 54, 1, 2, 4, 7, 5, 4, 1], 4, [100, 54, 1, 7, 4, 2, 5, 4, 1], 2, 7, '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $expected
     * @param mixed[]  $original
     * @param int      $expectedPivot Позиция опорного элемента после упорядочивания массива
     * @param int      $lo            Нижний индекс
     * @param int      $hi            Верхний индекс
     * @param callable $sortFn
     * @dataProvider dataForTestQuickSorterHoarePartition
     */
    public function testQuickSorterHoarePartition(array $expected, int $expectedPivot, array $original, int $lo, int $hi, callable $sortFn): void
    {
        $sorter = new QuickSorter($sortFn);
        $this->assertEquals($expectedPivot, $sorter->hoarePartition($original, $lo, $hi));
        $this->assertEquals($expected, $original);
    }

    public function dataForTestQuickSorterHoarePartition(): array
    {
        return [
            [[], 0, [], 0, 0, '__SortersTest__eq'],
            [[1], 0, [1], 0, 0, '__SortersTest__eq'],
            [[1, 2], 0, [2, 1], 0, 1, '__SortersTest__eq'],
            [[2, 1, 7, 4, 4, 5], 1, [4, 1, 7, 4, 2, 5], 0, 5, '__SortersTest__eq'],
            [[1, 54, 1, 7, 4, 2, 5, 4, 100, 100], 7, [100, 54, 1, 7, 4, 2, 5, 100, 4, 1], 0, 9, '__SortersTest__eq'],
            [[1, 1, 3, 2, 3, 2], 1, [1, 2, 3, 1, 3, 2], 1, 5, '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $original
     * @param callable $sortFn
     * @dataProvider dataForTestMergeSorterSort
     */
    public function testMergeSorterSort(array $original, callable $sortFn): void
    {
        $expected = $original;
        $this->assertTrue(usort($expected, $sortFn));

        $sorter = new MergeSorter($sortFn);
        $this->assertEquals($expected, $sorter->sort($original));
    }

    public function dataForTestMergeSorterSort(): array
    {
        return [
            [[], '__SortersTest__eq'],
            [[1], '__SortersTest__eq'],
            [[3, 2], '__SortersTest__eq'],
            [[100, 54, 1, 7, 4, 2, 5, 4, 1], '__SortersTest__eq'],
        ];
    }

    /**
     * @param mixed[]  $expected
     * @param mixed[]  $first
     * @param mixed[]  $second
     * @param callable $sortFn
     * @dataProvider dataForTestMergeSorterMerge
     */
    public function testMergeSorterMerge(array $expected, array $first, array $second, callable $sortFn): void
    {
        $sorter = new MergeSorter($sortFn);
        $this->assertEquals($expected, $sorter->merge($first, $second));
    }

    public function dataForTestMergeSorterMerge(): array
    {
        return [
            [[], [], [], '__SortersTest__eq'],
            [[1, 4, 5, 100], [1, 4, 5, 100], [], '__SortersTest__eq'],
            [[2, 7, 54], [], [2, 7, 54], '__SortersTest__eq'],
            [[1, 1, 2, 4, 4, 5, 7, 54, 100], [1, 4, 5, 100], [1, 2, 4, 7, 54], '__SortersTest__eq'],
        ];
    }
}

function __SortersTest__eq($a, $b)
{
    // Сортировка по возрастанию
    return $a <=> $b;
}
