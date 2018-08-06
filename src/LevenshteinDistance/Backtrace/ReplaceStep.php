<?php

namespace Sth348962\Algorithms\LevenshteinDistance\Backtrace;

class ReplaceStep extends Step
{
    protected $from;
    protected $to;
    protected $col;
    protected $row;

    public function __construct(string $from, string $to, int $col, int $row)
    {
        $this->from = $from;
        $this->to = $to;
        $this->col = $col;
        $this->row = $row;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getCol(): int
    {
        return $this->col;
    }

    public function getRow(): int
    {
        return $this->row;
    }
}