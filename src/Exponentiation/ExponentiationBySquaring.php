<?php

namespace Sth348962\Algorithms\Exponentiation;

use InvalidArgumentException;

/**
 * Реализация алгоритма быстрого возведения числа в степень.
 */
class ExponentiationBySquaring
{
    /**
     * @param int $x Число, которое требуется возвести в степень $n
     * @param int $n Степень
     * @return int
     * @throws \InvalidArgumentException
     */
    public function calc(int $x, int $n): int
    {
        if ($n < 0) {
            throw new InvalidArgumentException('An exponent value must not be negative');
        }

        $result = 1;
        while ($n != 0) {
            if ($n % 2 === 1) {
                $result = $result * $x;
            }
            $n = $n >> 1;

            // Мы не трогаем непосредственно переменную $result,
            // т.к. возведение в целую неотрицательную степень всегда будет оканчиваться на нечетном $n == 1.
            $x = $x * $x;
        }
        return $result;
    }
}