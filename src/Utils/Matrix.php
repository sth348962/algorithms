<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Utils;

use OutOfBoundsException;

class Matrix implements IMatrix
{
    protected $rows;
    protected $columns;
    protected $origin;

    /**
     * @param mixed[][] $origin
     * @param int       $rows    Число строк
     * @param int       $columns Число столбцов
     */
    protected function __construct(array $origin, int $rows, int $columns)
    {
        $this->rows = $rows;
        $this->columns = $columns;
        $this->origin = $origin;
    }

    public static function createWithArray(array $origin): IMatrix
    {
        $rows = count($origin);
        $columns = ($rows === 0) ? 0 : count($origin[0]);

        return new static($origin, $rows, $columns);
    }

    public static function createWithDimensions(int $rows, int $columns): IMatrix
    {
        return new static([], $rows, $columns);
    }

    /**
     * {@inheritdoc}
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * {@inheritdoc}
     */
    public function columns(): int
    {
        return $this->columns;
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $row, int $col)
    {
        if ($row >= $this->rows || $col >= $this->columns) {
            throw new OutOfBoundsException('There is no such element');
        }

        return $this->origin[$row][$col];
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $row, int $col, $value): IMatrix
    {
        if ($row >= $this->rows || $col >= $this->columns) {
            throw new OutOfBoundsException('There is no such element');
        }

        $this->origin[$row][$col] = $value;

        return $this;
    }
}
