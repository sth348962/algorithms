<?php

namespace Sth348962\Algorithms\ClosestPair;

/**
 * Промежуточные результаты алгоритма
 */
class StepResult
{
    protected $distance;
    protected $closestPoints;
    protected $pointsSortedByY;

    public function __construct(float $distance, array $closestPoints, array $pointsSortedByY)
    {
        $this->distance = $distance;
        $this->closestPoints = $closestPoints;
        $this->pointsSortedByY = $pointsSortedByY;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function getClosestPoints(): array
    {
        return $this->closestPoints;
    }

    public function getPointsSortedByY(): array
    {
        return $this->pointsSortedByY;
    }
}