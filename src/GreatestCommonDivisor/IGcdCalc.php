<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\GreatestCommonDivisor;

interface IGcdCalc
{
    /**
     * Вычисление НОД.
     *
     * @param int $a
     * @param int $b
     *
     * @return int
     */
    public function calc(int $a, int $b): int;
}
