<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Matrix;

use OutOfBoundsException;
use Sth348962\Algorithms\Utils\IMatrix;

class Submatrix implements IMatrix
{
    /**
     * @var \Sth348962\Algorithms\Utils\IMatrix
     */
    protected $origin;

    protected $rowIndex;
    protected $rows;
    protected $colIndex;
    protected $columns;

    /**
     * @param \Sth348962\Algorithms\Utils\IMatrix $origin
     * @param int                                 $rowIndex Первая строка
     * @param int                                 $rows     Число строк
     * @param int                                 $colIndex Первый столбец
     * @param int                                 $columns  Число столбцов
     */
    public function __construct(IMatrix $origin, int $rowIndex, int $rows, int $colIndex, int $columns)
    {
        $this->origin = $origin;
        $this->rowIndex = $rowIndex;
        $this->rows = $rows;
        $this->colIndex = $colIndex;
        $this->columns = $columns;
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
        $row = $this->rowIndex + $row;
        $col = $this->colIndex + $col;

        if (($row >= $this->rowIndex + $this->rows) || ($col >= $this->colIndex + $this->columns)) {
            throw new OutOfBoundsException('There is no such element');
        }

        return $this->origin->get($row, $col);
    }

    /**
     * {@inheritdoc}
     */
    public function set(int $row, int $col, $value): IMatrix
    {
        $row = $this->rowIndex + $row;
        $col = $this->colIndex + $col;

        if (($row >= $this->rowIndex + $this->rows) || ($col >= $this->colIndex + $this->columns)) {
            throw new OutOfBoundsException('There is no such element');
        }

        $this->origin->set($row, $col, $value);

        return $this;
    }
}
