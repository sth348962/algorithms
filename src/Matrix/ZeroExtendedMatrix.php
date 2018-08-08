<?php

namespace Sth348962\Algorithms\Matrix;

use InvalidArgumentException;
use OutOfBoundsException;

use Sth348962\Algorithms\Utils\IMatrix;

/**
 * Матрица, расширяющая базовую.
 *
 * Элементы, которых нет в базовой, принимаются равными нулю.
 */
class ZeroExtendedMatrix implements IMatrix
{
    /**
     * @var \Sth348962\Algorithms\Utils\IMatrix
     */
    protected $origin;

    protected $rows;
    protected $columns;
    protected $originalRows;
    protected $originalColumns;

    /**
     * @param \Sth348962\Algorithms\Utils\IMatrix $origin
     * @param int $rows Число строк
     * @param int $columns Число столбцов
     */
    public function __construct(IMatrix $origin, int $rows, int $columns)
    {
        $this->originalRows = $origin->rows();
        $this->originalColumns = $origin->columns();

        // Число строк и столбцов должно быть как минимум не меньше, чем в оригинальной матрице
        if ($this->originalRows > $rows || $this->originalColumns > $columns) {
            throw new InvalidArgumentException('A number of rows and columns of extended matrix must not be less than the number of rows and columns of the original one');
        }

        $this->origin = $origin;
        $this->rows = $rows;
        $this->columns = $columns;
    }

    /**
     * @inheritdoc
     */
    public function rows(): int
    {
        return $this->rows;
    }

    /**
     * @inheritdoc
     */
    public function columns(): int
    {
        return $this->columns;
    }

    /**
     * @inheritdoc
     */
    public function get(int $row, int $col)
    {
        if ($row >= $this->rows || $col >= $this->columns) {
            throw new OutOfBoundsException('There is no such element');
        }

        if ($row >= $this->originalRows || $col >= $this->originalColumns) {
            return 0;
        }

        return $this->origin->get($row, $col);
    }

    /**
     * @inheritdoc
     */
    public function set(int $row, int $col, $value): IMatrix
    {
        throw new InvalidArgumentException("Can't mutate matrix");
    }
}