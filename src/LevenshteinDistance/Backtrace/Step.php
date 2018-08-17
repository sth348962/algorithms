<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\LevenshteinDistance\Backtrace;

abstract class Step
{
    public static function root(): self
    {
        return new RootStep();
    }

    public static function insert(string $char, int $col, int $row): self
    {
        return new InsertStep($char, $col, $row);
    }

    public static function replace(string $from, string $to, int $col, int $row): self
    {
        return new ReplaceStep($from, $to, $col, $row);
    }

    public static function delete(string $char, int $col, int $row): self
    {
        return new DeleteStep($char, $col, $row);
    }

    public static function match(string $char, int $col, int $row): self
    {
        return new MatchStep($char, $col, $row);
    }

    abstract public function getCol(): int;

    abstract public function getRow(): int;
}
