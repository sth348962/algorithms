<?php

namespace Sth348962\Algorithms\MaximumSubarrayProblem;

class Subarray
{
    /**
     * @var int Индекс начала подмассива
     */
    protected $start;

    /**
     * @var int Длина подмассива
     */
    protected $length;

    public function __construct(int $start, int $length)
    {
        $this->start = $start;
        $this->length = $length;
    }

    public function getStart(): int
    {
        return $this->start;
    }

    public function getLength(): int
    {
        return $this->length;
    }

    public function __toString(): string
    {
        return $this->start . ':' . $this->length;
    }
}