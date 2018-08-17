<?php

declare(strict_types=1);

namespace Sth348962\Algorithms\Matrix;

use InvalidArgumentException;
use Sth348962\Algorithms\Utils\IMatrix;
use Sth348962\Algorithms\Utils\Matrix;

class StrassenAlgorithm
{
    /**
     * @var \Sth348962\Algorithms\Matrix\Calc
     *
     * Используется для операций сложения, вычитания и умножения матриц
     */
    protected $calc;

    public function __construct(Calc $calc)
    {
        $this->calc = $calc;
    }

    /**
     * Вычисляет произведение двух матриц, возвращая новую матрицу.
     *
     * @param \Sth348962\Algorithms\Utils\IMatrix $m1
     * @param \Sth348962\Algorithms\Utils\IMatrix $m2
     *
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

        /**
         * Дополняем обе матрицы до квадратной размера N^2^M (т.е. размерность которых кратны степени 2).
         *
         * @todo Необязательно. Например, матрицы размера 1600x1600 можно свести к матрицам размера 25x25, которые быстрее будет умножить обычным методом.
         * @todo Проверить, может быть матрицы уже квадратные и нужной размерности.
         */
        $d = (int) (2 ** ceil(log(max($toMultiply, $rows, $columns), 2)));
        $product = $this->step(
            new ZeroExtendedMatrix($m1, $d, $d),
            new ZeroExtendedMatrix($m2, $d, $d)
        );

        // Урезаем результирующую матрицу до нужного размера
        return new Submatrix($product, 0, $rows, 0, $columns);
    }

    /**
     * Вычисляет произведение двух матриц (квадратных, размерность которых кратна степени 2), возвращая новую матрицу.
     *
     * @param \Sth348962\Algorithms\Utils\IMatrix $m1
     * @param \Sth348962\Algorithms\Utils\IMatrix $m2
     *
     * @return \Sth348962\Algorithms\Utils\IMatrix
     */
    protected function step(IMatrix $m1, IMatrix $m2)
    {
        $dOriginal = $m1->columns();
        if ($dOriginal > 1) {
            $d = $dOriginal / 2;

            //     +-        -+
            //     | A11  A12 |
            // A = |          |
            //     | A21  A22 |
            //     +-        -+
            //
            //     +-        -+
            //     | B11  B12 |
            // B = |          |
            //     | B21  B22 |
            //     +-        -+
            //
            //     +-        -+
            //     | C11  C12 |
            // C = |          |
            //     | C21  C22 |
            //     +-        -+
            //
            // где
            //
            // C11 = A11 * B11 + A12 * B21
            // C12 = A11 * B12 + A12 * B22
            // C21 = A21 * B11 + A22 * B21
            // C22 = A21 * B12 + A22 * B22

            $a11 = new Submatrix($m1, 0, $d, 0, $d);
            $a12 = new Submatrix($m1, 0, $d, $d, $d);
            $a21 = new Submatrix($m1, $d, $d, 0, $d);
            $a22 = new Submatrix($m1, $d, $d, $d, $d);

            $b11 = new Submatrix($m2, 0, $d, 0, $d);
            $b12 = new Submatrix($m2, 0, $d, $d, $d);
            $b21 = new Submatrix($m2, $d, $d, 0, $d);
            $b22 = new Submatrix($m2, $d, $d, $d, $d);

            $m1 = $this->step(
                $this->calc->add($a11, $a22),
                $this->calc->add($b11, $b22)
            );
            $m2 = $this->step(
                $this->calc->add($a21, $a22),
                $b11
            );
            $m3 = $this->step(
                $a11,
                $this->calc->sub($b12, $b22)
            );
            $m4 = $this->step(
                $a22,
                $this->calc->sub($b21, $b11)
            );
            $m5 = $this->step(
                $this->calc->add($a11, $a12),
                $b22
            );
            $m6 = $this->step(
                $this->calc->sub($a21, $a11),
                $this->calc->add($b11, $b12)
            );
            $m7 = $this->step(
                $this->calc->sub($a12, $a22),
                $this->calc->add($b21, $b22)
            );

            $c11 = $this->calc->add($this->calc->sub($this->calc->add($m1, $m4), $m5), $m7);
            $c12 = $this->calc->add($m3, $m5);
            $c21 = $this->calc->add($m2, $m4);
            $c22 = $this->calc->add($this->calc->add($this->calc->sub($m1, $m2), $m3), $m6);

            // Собираем результирующую матрицу
            $c = Matrix::createWithDimensions($d * 2, $d * 2);
            for ($i = 0; $i < $d; $i++) {
                for ($j = 0; $j < $d; $j++) {
                    $c->set($i, $j, $c11->get($i, $j));
                    $c->set($i, $d + $j, $c12->get($i, $j));
                    $c->set($d + $i, $j, $c21->get($i, $j));
                    $c->set($d + $i, $d + $j, $c22->get($i, $j));
                }
            }

            return $c;
        }

        // Если матрица состоит из одной строки и одного столбца
        return Matrix::createWithArray([
            [$m1->get(0, 0) * $m2->get(0, 0)],
        ]);
    }
}
