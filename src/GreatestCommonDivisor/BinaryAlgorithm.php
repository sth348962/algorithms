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
        if ($a === 0) {
            return $b;
        }

        if ($b === 0) {
            return $a;
        }

        $aIsEven = ($a % 2 === 0);
        $bIsEven = ($b % 2 === 0);

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
