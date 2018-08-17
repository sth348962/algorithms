<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Sorters;

use RuntimeException;

class QuickSorter extends Sorter
{
    /**
     * Самая простая реализация.
     *
     * @param mixed[] $original
     *
     * @return mixed[] Новый массив с отсортированными элементами
     */
    public function sort(array $original): array
    {
        $length = count($original);

        if ($length < 2) {
            // Если в массиве меньше 2 элементов
            return $original;
        }

        $left = [];
        $middle = [];
        $right = [];
        $pivot = $original[0];
        foreach ($original as $item) {
            switch (call_user_func($this->sortFn, $item, $pivot)) {
                case -1:
                    $left[] = $item;

                    break;
                case 0:
                    $middle[] = $item;

                    break;
                case 1:
                    $right[] = $item;

                    break;
                default:
                    throw new RuntimeException('Unreachable code');
            }
        }

        return array_merge(
            $this->sort($left),
            $middle,
            $this->sort($right)
        );
    }

    /**
     * Быстрая сортировка переданного массива с использованием разбиения Ломуто.
     *
     * @param mixed[] $original Массив передается по ссылке
     * @param int     $lo
     * @param int     $hi
     *
     * @return bool
     */
    public function mSortUsingLomutoPartition(array &$original, int $lo, int $hi): bool
    {
        if ($lo >= $hi) {
            return true;
        }
        $pivot = $this->lomutoPartition($original, $lo, $hi);

        return $this->mSortUsingLomutoPartition($original, $lo, $pivot - 1) &&
            $this->mSortUsingLomutoPartition($original, $pivot + 1, $hi);
    }

    /**
     * Быстрая сортировка переданного массива с использованием разбиения Хоара.
     *
     * @param mixed[] $original Массив передается по ссылке
     * @param int     $lo
     * @param int     $hi
     *
     * @return bool
     */
    public function mSortUsingHoarePartition(array &$original, int $lo, int $hi): bool
    {
        if ($lo >= $hi) {
            return true;
        }
        $pivot = $this->hoarePartition($original, $lo, $hi);

        return $this->mSortUsingHoarePartition($original, $lo, $pivot) &&
            $this->mSortUsingHoarePartition($original, $pivot + 1, $hi);
    }

    /**
     * Разбиение Ломуто.
     *
     * @param mixed[] $original Массив передается по ссылке
     * @param int     $lo
     * @param int     $hi
     *
     * @return int Позиция опорного элемента
     */
    public function lomutoPartition(array &$original, int $lo, int $hi): int
    {
        if ($lo === $hi) {
            // Если в массиве меньше 2 элементов
            return $hi;
        }

        // Опорный элемент
        $pivot = $original[$hi];

        $i = $lo - 1;
        for ($j = $lo; $j < $hi; $j++) {
            if (call_user_func($this->sortFn, $original[$j], $pivot) < 0) {
                $i++;
                if ($i !== $j) {
                    // Индекс i хранит позицию ближайшего элемента, который больше или равен опорному
                    [$original[$i], $original[$j]] = [$original[$j], $original[$i]];
                }
            }
        }

        $i++;
        if ($i !== $hi) {
            // Нужно поменять местами ближайший элемент, который больше или равен опорному, с самим опорным элементом
            [$original[$i], $original[$hi]] = [$original[$hi], $original[$i]];
        }

        return $i;
    }

    /**
     * Разбиение Хоара.
     *
     * @param mixed[] $original Массив передается по ссылке
     * @param int     $lo
     * @param int     $hi
     *
     * @return int Позиция элемента, который можно считать опорным
     */
    public function hoarePartition(array &$original, int $lo, int $hi): int
    {
        if ($lo === $hi) {
            // Если в массиве меньше 2 элементов
            return $hi;
        }

        // Опорный элемент
        $pivot = $original[$lo];

        $i = $lo - 1;
        $j = $hi + 1;
        while (true) {
            // Получаем позицию первого элемента, который больше или равен опорному
            do {
                $i++;
            } while (call_user_func($this->sortFn, $original[$i], $pivot) < 0);

            // Получаем позицию последнего элемента, который меньше или равен опорному
            do {
                $j--;
            } while ($j > $lo && call_user_func($this->sortFn, $original[$j], $pivot) >= 0);

            if ($i >= $j) {
                // Возвращаем позицию элемента, который стоит в "правильном" месте
                return $j;
            }

            [$original[$i], $original[$j]] = [$original[$j], $original[$i]];
        }

        throw new RuntimeException('Unreachable code');
    }
}
