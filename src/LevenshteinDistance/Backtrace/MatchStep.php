<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\LevenshteinDistance\Backtrace;

class MatchStep extends Step
{
    protected $char;
    protected $col;
    protected $row;

    public function __construct(string $char, int $col, int $row)
    {
        $this->char = $char;
        $this->col = $col;
        $this->row = $row;
    }

    public function getChar(): string
    {
        return $this->char;
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
