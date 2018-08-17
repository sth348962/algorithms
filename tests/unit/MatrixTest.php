<?php

declare(strict_types=1);

use Sth348962\Algorithms\Matrix\Calc;
use Sth348962\Algorithms\Matrix\StrassenAlgorithm;
use Sth348962\Algorithms\Matrix\Submatrix;
use Sth348962\Algorithms\Matrix\TransposeMatrix;
use Sth348962\Algorithms\Utils\IMatrix;
use Sth348962\Algorithms\Utils\Matrix;

/**
 * @internal
 * @coversNothing
 */
final class MatrixTest extends \Codeception\Test\Unit
{
    public function testBasic(): void
    {
        $m = Matrix::createWithArray([
            [1, 2, -1, 3],
            [2, 0, 1, 3],
        ]);
        $this->assertInstanceOf(IMatrix::class, $m);
        $this->assertEquals(-1, $m->get(0, 2));
        $this->assertEquals(2, $m->get(1, 0));

        // Получаем квадратную матрицу 2x2 с 0 строки столбца 1
        $sm = new Submatrix($m, 0, 2, 1, 2);
        $this->assertInstanceOf(IMatrix::class, $sm);
        $this->assertEquals(-1, $sm->get(0, 1));
        $this->assertEquals(0, $sm->get(1, 0));

        // Нельзя выходить за пределы подматрицы
        try {
            $sm->get(0, 2);
            // Unreachable code
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertInstanceOf(OutOfBoundsException::class, $e);
        }

        // Проверяем число строк и столбцов
        $this->assertEquals(2, $m->rows());
        $this->assertEquals(4, $m->columns());
        $this->assertEquals(2, $sm->rows());
        $this->assertEquals(2, $sm->columns());

        // Установка значения
        $m->set(1, 2, -5);
        $this->assertEquals(-5, $m->get(1, 2));
        $this->assertEquals(-5, $sm->get(1, 1));
        $sm->set(1, 1, -10);
        $this->assertEquals(-10, $m->get(1, 2));
        $this->assertEquals(-10, $sm->get(1, 1));

        // Создаем пустую матрицу и заполняем её значениями
        $m = Matrix::createWithDimensions(3, 3);
        for ($i = 3; $i--;) {
            for ($j = 3; $j--;) {
                $m->set($i, $j, $i * 100 + $j * 10);
            }
        }
        $this->assertEquals(220, $m->get(2, 2));
        $this->assertEquals(110, $m->get(1, 1));
        $this->assertEquals(10, $m->get(0, 1));
    }

    /**
     * Сложение матриц.
     */
    public function testCalcAdd(): void
    {
        $m1 = Matrix::createWithArray([
            [4, -2],
            [0, -1],
            [0, 0],
        ]);

        $m2 = Matrix::createWithArray([
            [-4, -2],
            [1, 3],
            [1, 1],
        ]);

        $calc = new Calc();
        $this->tester->assertEqualsMatrix(Matrix::createWithArray([
            [0, -4],
            [1, 2],
            [1, 1],
        ]), $calc->add($m1, $m2));
    }

    /**
     * Вычитание матриц.
     */
    public function testCalcSub(): void
    {
        $m1 = Matrix::createWithArray([
            [4, -2],
            [0, -1],
            [0, 0],
        ]);

        $m2 = Matrix::createWithArray([
            [-4, -2],
            [1, 3],
            [1, 1],
        ]);

        $calc = new Calc();
        $this->tester->assertEqualsMatrix(Matrix::createWithArray([
            [8, 0],
            [-1, -4],
            [-1, -1],
        ]), $calc->sub($m1, $m2));
    }

    public function testTranspose(): void
    {
        $calc = new Calc();

        $m0 = Matrix::createWithArray([]);
        $m1 = Matrix::createWithArray([[1]]);
        $m2 = Matrix::createWithArray([[1, 2], [3, 4], [5, 6]]);

        $this->tester->assertEqualsMatrix(Matrix::createWithArray([]), $calc->transpose($m0));
        $this->tester->assertEqualsMatrix(Matrix::createWithArray([[1]]), $calc->transpose($m1));
        $this->tester->assertEqualsMatrix(Matrix::createWithArray([[1, 3, 5], [2, 4, 6]]), $calc->transpose($m2));

        // Спецкласс для транспонирования матрицы за счет перехвата вызова её методов
        $expected = $calc->transpose($m2);
        $actual = new TransposeMatrix($m2);
        $rows = $expected->rows();
        $columns = $expected->columns();
        for ($i = $rows; $i--;) {
            for ($j = $columns; $j--;) {
                $this->assertEquals($expected->get($i, $j), $actual->get($i, $j));
            }
        }
    }

    public function testMultiplication(): void
    {
        $calc = new Calc();

        $m1 = Matrix::createWithArray([
            [-1, 1],
            [2, 0],
            [0, 3],
        ]);

        $m2 = Matrix::createWithArray([
            [3, 1, 2, 0],
            [0, -1, 4, 0],
        ]);

        $this->tester->assertEqualsMatrix(Matrix::createWithArray([
            [-3, -2, 2, 0],
            [6, 2, 4, 0],
            [0, -3, 12, 0],
        ]), $calc->multiply($m1, $m2));

        // Проверяем работу реализации алгоритма Штрасссена
        $strassen = new StrassenAlgorithm($calc);
        $this->tester->assertEqualsMatrix($calc->multiply($m1, $m2), $strassen->multiply($m1, $m2));
    }
}
