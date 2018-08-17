<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Matrix;

use Sth348962\Algorithms\Utils\IMatrix;

/**
 * Транспонированная матрица.
 *
 * Меняет только индексы оригинальной матрицы при вызове методов, не трогая саму матрицу.
 */
class TransposeMatrix implements IMatrix
{
    /**
     * @var \Sth348962\Algorithms\Utils\IMatrix
     */
    protected $original;

    public function __construct(IMatrix $original)
    {
        $this->original = $original;
    }

    /**
     * {@inheritdoc}
     */
    public function columns(): int
    {
        $this->original->rows();
    }

    /**
     * {@inheritdoc}
     */
    public function rows(): int
    {
        $this->original->columns();
    }

    /**
     * {@inheritdoc}
     */
    public function get(int $row, int $col)
    {
        return $this->original->get($col, $row);
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $row, int $col, $value): IMatrix
    {
        return $this->original->set($col, $row, $value);
    }
}
