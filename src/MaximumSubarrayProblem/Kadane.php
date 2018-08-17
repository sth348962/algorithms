<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\MaximumSubarrayProblem;

use RuntimeException;

class Kadane
{
    /**
     * Поиск всех максимальных последовательностей в массиве $original,
     * ограниченных индексами $from и $to (включительно),
     * используя алгоритм, предложенный Джеем Каданом.
     *
     * @param int[] $original
     * @param int   $from
     * @param int   $to
     *
     * @return \Sth348962\Algorithms\MaximumSubarrayProblem\Result
     */
    public function find(array $original, int $from, int $to): Result
    {
        $length = $to - $from + 1;
        if ($length <= 0) {
            throw new RuntimeException('Unreachable code');
        }

        // Максимальная сумма последовательностей
        $maxSum = $original[$from];

        // Сумма текущей последовательности
        $currentMaxSum = $original[$from];

        // Начало текущей последовательности
        $first = $from;

        $mdSubarrays = [$first => [new Subarray($first, 1)]];
        for ($i = $from + 1; $i <= $to; $i++) {
            $tmp = $currentMaxSum + $original[$i];
            $currentMaxSum = max($tmp, $original[$i]);
            if ($currentMaxSum > $tmp) {
                // Если мы начинаем новую последовательность (сравнение не должно быть строгим!)
                $first = $i;
            }

            $nextMaxSum = max($maxSum, $currentMaxSum);
            if ($nextMaxSum !== $maxSum) {
                // Если появилась последовательность с суммой, больше текущей
                $maxSum = $nextMaxSum;
                $mdSubarrays = [];
            }

            if ($currentMaxSum === $maxSum) {
                // Если текущая последовательность является максимальной
                $mdSubarrays[$first][] = new Subarray($first, $i - $first + 1);
            }
        }

        // Получаем наибольшие непересекающиеся последовательности,
        // попутно формируя новый массив $subarrays
        $longestSubarrays = [];
        $subarrays = [];
        foreach ($mdSubarrays as $tmp) {
            $longestSubarrays[] = end($tmp);
            $subarrays = array_merge($subarrays, $tmp);
        }

        foreach ($longestSubarrays as $subarray) {
            $from = $subarray->getStart();
            $to = $subarray->getStart() + $subarray->getLength() - 1;

            // Первый элемент последовательности не может быть отрицательным,
            // в противном случае он будет единственным и проверять нечего.
            // Тоже самое касается последнего элемента - если он отрицательный,
            // то проверять просто нечего.
            for ($i = $from + 1; $i < $to; $i++) {
                if (0 !== $original[$i - 1] && $original[$i] > 0) {
                    // Мы ищем неположительные (!) элементы в последовательности,
                    // а так же элементы, которым предшествовал ноль
                    continue;
                }

                // Переходим к первому неотрицательному (!) элементу
                while ($i < $to && $original[$i] < 0) {
                    $i++;
                }

                // Сумма текущей последовательности
                $currentMaxSum = $original[$i];

                // Начало текущей последовательности
                $first = $i;

                if ($currentMaxSum === $maxSum) {
                    // Если текущая последовательность является максимальной
                    $subarrays[] = new Subarray($first, 1);
                }

                for ($j = $i + 1; $j <= $to; $j++) {
                    $tmp = $currentMaxSum + $original[$j];
                    $currentMaxSum = max($tmp, $original[$j]);
                    if ($currentMaxSum > $tmp) {
                        // При смене последовательности просто выходим
                        break;
                    }

                    if ($currentMaxSum === $maxSum) {
                        // Если текущая последовательность является максимальной
                        $subarrays[] = new Subarray($first, $j - $first + 1);
                    }
                }
            }
        }

        return new Result($maxSum, $subarrays);
    }
}
