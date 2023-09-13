<?php
/**
 * Tests for Calculator.
 */

namespace Util;

use App\Util\Calculator;
use PHPUnit\Framework\TestCase;

/**
 * Class CalculatorTest.
 */
class CalculatorTest extends TestCase
{
    /**
     * Test add() method.
     */
    public function testAdd()
    {
        $calculator = new Calculator();
        $result = $calculator->add(30, 12);

        $this->assertEquals(42, $result);
    }
}
