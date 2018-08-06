<?php

namespace Sth348962\Algorithms\Matrix;

use InvalidArgumentException;

use Sth348962\Algorithms\Utils\IMatrix;
use Sth348962\Algorithms\Utils\Matrix;

class Calc
{
    /**
     * Вычисляет сумму двух матриц, возвращая новую матрицу
     *
     * @param \Sth348962\Algorithms\Utils\IMatrix $m1
     * @param \Sth348962\Algorithms\Utils\IMatrix $m2
     * @return \Sth348962\Algorithms\Utils\IMatrix
     */
    public function add(IMatrix $m1, IMatrix $m2): IMatrix
    {
        if ($m1->rows() !== $m2->rows()) {
            throw new InvalidArgumentException('Two matrices must have an equal number of rows and columns to be added');
        }

        if ($m1->columns() !== $m2->columns()) {
            throw new InvalidArgumentException('Two matrices must have an equal number of rows and columns to be added');
        }

        $rows = $m1->rows();
        $columns = $m1->columns();
        $m = Matrix::createWithDimensions($rows, $columns);
        for ($i = $rows; $i--;) {
            for ($j = $columns; $j--;) {
                $m->set($i, $j, $m1->get($i, $j) + $m2->get($i, $j));
            }
        }
        return $m;
    }

    /**
     * Транспонирование матрицы $original
     *
     * @param \Sth348962\Algorithms\Utils\IMatrix $original
     * @return \Sth348962\Algorithms\Utils\IMatrix
     */
    public function transpose(IMatrix $original): IMatrix
    {
        $rows = $original->rows();
        $columns = $original->columns();
        $result = Matrix::createWithDimensions($columns, $rows);
        for ($i = $rows; $i--;) {
            for ($j = $columns; $j--;) {
                $result->set($j, $i, $original->get($i, $j));
            }
        }
        return $result;
    }

    /**
     * Вычисляет произведение двух матриц, возвращая новую матрицу
     *
     * @param \Sth348962\Algorithms\Utils\IMatrix $m1
     * @param \Sth348962\Algorithms\Utils\IMatrix $m2
     * @return \Sth348962\Algorithms\Utils\IMatrix
     */
    public function multiply(IMatrix $m1, IMatrix $m2): IMatrix
    {
        $toMultiply = $m1->columns();
        if ($toMultiply !== $m2->rows()) {
            throw new InvalidArgumentException('The number of columns of the left matrix must be the same as the number of rows of the right matrix');
        }

        $rows = $m1->rows();
        $columns = $m2->columns();
        $m = Matrix::createWithDimensions($rows, $columns);
        for ($i = $rows; $i--;) {
            for ($j = $columns; $j--;) {
                $product = 0;
                for ($k = $toMultiply; $k--;) {
                    $product = $product + $m1->get($i, $k) * $m2->get($k, $j);
                }
                $m->set($i, $j, $product);
            }
        }
        return $m;
    }
}