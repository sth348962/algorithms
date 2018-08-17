<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Utils;

class Point2D
{
    /**
     * @var float
     */
    protected $x;

    /**
     * @var float
     */
    protected $y;

    public function __construct(float $x, float $y)
    {
        $this->x = $x;
        $this->y = $y;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    /**
     * @param \Sth348962\Algorithms\Utils\Point2D $other
     *
     * @return float
     */
    public function distance(self $other): float
    {
        return sqrt(($this->x - $other->x) ** 2 + ($this->y - $other->y) ** 2);
    }

    public function compareX(self $other): int
    {
        return $this->x <=> $other->x;
    }

    public function compareY(self $other): int
    {
        return $this->y <=> $other->y;
    }
}
