<?php

use Sth348962\Algorithms\Exponentiation\ExponentiationBySquaring;

class ExponentiationTest extends \Codeception\Test\Unit
{
    public function testExponentiationBySquaring()
    {
        $exponentiation = new ExponentiationBySquaring();

        foreach ([0, 1, 2, 10, 21] as $n) {
            $this->assertEquals(3 ** $n, $exponentiation->calc(3, $n));
        }

        try {
            $exponentiation->calc(3, -1);
            // Unreachable code
            $this->assertEquals(true, false);
        } catch (Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
        }
    }
}