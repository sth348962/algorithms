<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\GreatestCommonDivisor;

class BinaryAlgorithm implements IGcdCalc
{
    /**
     * {@inheritdoc}
     */
    public function calc(int $a, int $b): int
    {
        if (0 === $a) {
            return $b;
        }

        if (0 === $b) {
            return $a;
        }

        $aIsEven = (0 === $a % 2);
        $bIsEven = (0 === $b % 2);

        if ($aIsEven && $bIsEven) {
            return 2 * $this->calc($a / 2, $b / 2);
        }

        if ($aIsEven) {
            return $this->calc($a / 2, $b);
        }

        if ($bIsEven) {
            return $this->calc($a, $b / 2);
        }

        if ($a >= $b) {
            return $this->calc(($a - $b) / 2, $b);
        }

        return $this->calc(($b - $a) / 2, $a);
    }
}
