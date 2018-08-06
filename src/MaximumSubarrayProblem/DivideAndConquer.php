<?php

namespace Sth348962\Algorithms\MaximumSubarrayProblem;

use RuntimeException;

class DivideAndConquer
{
    /**
     * Поиск всех максимальных последовательностей в массиве $original,
     * ограниченных индексами $from и $to (включительно).
     *
     * @param int[] $original
     * @param int $from
     * @param int $to
     * @return \Sth348962\Algorithms\MaximumSubarrayProblem\Result
     */
    public function find(array $original, int $from, int $to): Result
    {
        $length = $to - $from + 1;
        if ($length <= 0) {
            throw new RuntimeException('Unreachable code');
        }
        if ($length === 1) {
            // Базовый случай
            return new Result($original[$from], [new Subarray($from, $length)]);
        }

        // Рекурсивный случай

        // Индекс середины массива
        $mid = $from + ceil($length / 2) - 1;

        $left = $this->find($original, $from, $mid);
        $right = $this->find($original, $mid+1, $to);
        $middle = $this->findCrossingMid($original, $from, $mid, $to);

        // Объединяем результаты
        $subarrays = [];
        $maxSum = max($left->sum, $right->sum, $middle->sum);

        if ($maxSum === $left->sum) {
            $subarrays = array_merge($subarrays, $left->subarrays);
        }

        if ($maxSum === $right->sum) {
            $subarrays = array_merge($subarrays, $right->subarrays);
        }

        if ($maxSum === $middle->sum) {
            $subarrays = array_merge($subarrays, $middle->subarrays);
        }

        return new Result($maxSum, $subarrays);
    }

    /**
     * Поиск максимальной, пересекающей точку $mid последовательности в массиве $original,
     * ограниченного индексами $from и $to (включительно).
     *
     * @param int[] $original
     * @param int $from
     * @param int $mid
     * @param int $to
     * @return \Sth348962\Algorithms\MaximumSubarrayProblem\Result
     */
    public function findCrossingMid(array $original, int $from, int $mid, int $to): Result
    {
        $currentSum = 0;
        $maxLeftSum = PHP_INT_MIN;
        // Для левой последовательности точка $i = $mid является обязательной
        for ($i = $mid; $i >= $from; $i--) {
            $currentSum = $currentSum + $original[$i];
            if ($currentSum > $maxLeftSum) {
                $maxLeftSum = $currentSum;
                // Это условие будет выполнено минимум один раз,
                // поэтому можно оставить инициализацию переменной здесь
                $leftIndexes = [];
            }

            if ($currentSum === $maxLeftSum) {
                // Собираем все индексы с суммой, равной текущей максимальной
                $leftIndexes[] = $i;
            }
        }

        $currentSum = 0;
        $maxRightSum = PHP_INT_MIN;
        // Для правой последовательности точка $j = $mid + 1 является обязательной
        for ($j = $mid + 1; $j <= $to; $j++) {
            $currentSum = $currentSum + $original[$j];
            if ($currentSum > $maxRightSum) {
                $maxRightSum = $currentSum;
                // Это условие будет выполнено минимум один раз,
                // поэтому можно оставить инициализацию переменной здесь
                $rightIndexes = [];
            }

            if ($currentSum === $maxRightSum) {
                // Собираем все индексы с суммой, равной текущей максимальной
                $rightIndexes[] = $j;
            }
        }

        $subarrays = [];
        foreach ($leftIndexes as $leftIndex) {
            foreach ($rightIndexes as $rightIndex) {
                $subarrays[] = new Subarray($leftIndex, $rightIndex - $leftIndex + 1);
            }
        }

        return new Result($maxLeftSum + $maxRightSum, $subarrays);
    }
}