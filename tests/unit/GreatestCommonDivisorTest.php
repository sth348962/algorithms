<?php

use Sth348962\Algorithms\GreatestCommonDivisor\EuclideanAlgorithm;
use Sth348962\Algorithms\GreatestCommonDivisor\BinaryAlgorithm;

class GreatestCommonDivisorTest extends \Codeception\Test\Unit
{
    /**
     * Вычисление НОД по алгоритму Евклида.
     */
    public function testEuclideanAlgorithm()
    {
        $gcd = new EuclideanAlgorithm();
        $this->assertEquals(6, $gcd->calc(24, 54));
        $this->assertEquals(6, $gcd->calc(54, 24));
    }

    /**
     * Использование бинарного алгоритма вычисления НОД.
     */
    public function testBinaryAlgorithm()
    {
        $gcd = new BinaryAlgorithm();
        $this->assertEquals(0, $gcd->calc(0, 0));
        $this->assertEquals(54, $gcd->calc(0, 54));
        $this->assertEquals(24, $gcd->calc(24, 0));
        $this->assertEquals(6, $gcd->calc(24, 54));
        $this->assertEquals(3, $gcd->calc(12, 3));
        $this->assertEquals(15, $gcd->calc(45, 30));
        $this->assertEquals(1, $gcd->calc(187, 43));
        $this->assertEquals(1, $gcd->calc(47, 99));
    }
}