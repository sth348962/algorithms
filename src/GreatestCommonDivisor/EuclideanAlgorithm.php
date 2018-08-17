<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\GreatestCommonDivisor;

/**
 * Нахождение наибольшего общего делителя при помощи алгоритма Евклида.
 */
class EuclideanAlgorithm implements IGcdCalc
{
    /**
     * Предполагается, что $a >= $b, однако, алгоритм будет работать и если это не так,
     * просто первый шаг алгоритма уйдёт на "сортировку".
     *
     * Например,
     *
     * $this->calc(3, 27)
     *
     * на первом шаге выполнения алгоритма превращается в
     *
     * $this->calc(27, 3 % 27) === $this->calc(27, 3)
     *
     * т.к. остаток от деления 3 на 27 равен 3.
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    public function calc(int $a, int $b): int
    {
        if (0 === $b) {
            return $a;
        }

        return $this->calc($b, $a % $b);
    }
}
