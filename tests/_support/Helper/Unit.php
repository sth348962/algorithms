<?php

declare(strict_types=1);

namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Sth348962\Algorithms\Utils\IMatrix;

class Unit extends \Codeception\Module
{
    public function assertEqualsMatrix(IMatrix $m1, IMatrix $m2): void
    {
        $r = $m1->rows();
        $c = $m1->columns();

        // У одинаковых матриц должна быть одинаковая размерность
        $this->assertEquals($r, $m2->rows(), 'Matrices must have the same number of rows');
        $this->assertEquals($c, $m2->columns(), 'Matrices must have the same number of columns');

        for ($i = 0; $i < $r; $i++) {
            for ($j = 0; $j < $c; $j++) {
                $this->assertEquals($m1->get($i, $j), $m2->get($i, $j), "Element [${i}][${j}] must be the same");
            }
        }
    }
}
