<?php

namespace Sth348962\Algorithms\Utils;

interface IMatrix
{
    /**
     * Возвращает число столбцов матрицы
     *
     * @return int
     */
    public function columns(): int;

    /**
     * Возвращает число строк матрицы
     *
     * @return int
     */
    public function rows(): int;

    /**
     * @param int $row Строка; нумерация с нулевого индекса
     * @param int $col Столбец; нумерация с нулевого индекса
     * @return mixed Элемент на пересечении строки $row и столбца $col
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function get(int $row, int $col);

    /**
     * @param int $row Строка; нумерация с нулевого индекса
     * @param int $col Столбец; нумерация с нулевого индекса
     * @param mixed $value Значение ячейки
     * @return \Sth348962\Algorithms\Utils\IMatrix
     * @throws \OutOfBoundsException
     * @throws \InvalidArgumentException
     */
    public function set(int $row, int $col, $value): IMatrix;
}