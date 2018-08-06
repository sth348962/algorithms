<?php

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
     * @return float
     */
    public function distance(Point2D $other): float
    {
        return sqrt(($this->x - $other->x) ** 2 + ($this->y - $other->y) ** 2);
    }

    public function compareX(Point2D $other): int
    {
        return $this->x <=> $other->x;
    }

    public function compareY(Point2D $other): int
    {
        return $this->y <=> $other->y;
    }
}