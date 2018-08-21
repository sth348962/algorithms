<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Sorters;

class MergeSorter extends Sorter
{
    public function sort(array $original): array
    {
        $length = count($original);

        // Если пустой массив или 1 элемент
        if ($length < 2) {
            return $original;
        }

        // Середина массива
        $mid = (int) (ceil($length / 2));
        [$left, $right] = array_chunk($original, $mid);

        $leftSorted = $this->sort($left);
        $rightSorted = $this->sort($right);

        return $this->merge($leftSorted, $rightSorted);
    }

    /**
     * Принимает на вход два отсортированных массива,
     * возвращая их отсортированное объединение.
     *
     * @param array $left
     * @param array $right
     *
     * @return array
     */
    public function merge(array $left, array $right): array
    {
        $leftLength = count($left);
        $rightLength = count($right);

        // Если один из массивов пустой
        if ($leftLength === 0) {
            return $right;
        }

        if ($rightLength === 0) {
            return $left;
        }

        $result = [];
        $leftIndex = 0;
        $rightIndex = 0;
        $length = $leftLength + $rightLength;
        for ($i = 0; $i < $length; $i++) {
            // Если закончился левый массив - просто берем элементы правого и наоборот
            if ($leftIndex >= $leftLength) {
                $result[$i] = $right[$rightIndex];
                $rightIndex++;

                continue;
            }
            if ($rightIndex >= $rightLength) {
                $result[$i] = $left[$leftIndex];
                $leftIndex++;

                continue;
            }

            // Иначе - в соответствии с сортировкой
            if (call_user_func($this->sortFn, $left[$leftIndex], $right[$rightIndex]) < 0) {
                $result[$i] = $left[$leftIndex];
                $leftIndex++;
            } else {
                $result[$i] = $right[$rightIndex];
                $rightIndex++;
            }
        }

        return $result;
    }
}
