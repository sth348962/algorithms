<?php

declare(strict_types=1);

use Sth348962\Algorithms\Exponentiation\ExponentiationBySquaring;

/**
 * @internal
 */
final class ExponentiationTest extends \Codeception\Test\Unit
{
    public function testExponentiationBySquaring(): void
    {
        $exponentiation = new ExponentiationBySquaring();

        foreach ([0, 1, 2, 10, 21] as $n) {
            $this->assertEquals(3 ** $n, $exponentiation->calc(3, $n));
        }

        try {
            $exponentiation->calc(3, -1);
            // Unreachable code
            $this->assertTrue(false);
        } catch (Exception $e) {
            $this->assertInstanceOf(InvalidArgumentException::class, $e);
        }
    }
}
