<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Utils;

interface IMatrix
{
    /**
     * Возвращает число столбцов матрицы.
     *
     * @return int
     */
    public function columns(): int;

    /**
     * Возвращает число строк матрицы.
     *
     * @return int
     */
    public function rows(): int;

    /**
     * @param int $row Строка; нумерация с нулевого индекса
     * @param int $col Столбец; нумерация с нулевого индекса
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     *
     * @return mixed Элемент на пересечении строки $row и столбца $col
     */
    public function get(int $row, int $col);

    /**
     * @param int   $row   Строка; нумерация с нулевого индекса
     * @param int   $col   Столбец; нумерация с нулевого индекса
     * @param mixed $value Значение ячейки
     *
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     *
     * @return \Sth348962\Algorithms\Utils\IMatrix
     */
    public function set(int $row, int $col, $value): self;
}
