<?php

namespace Tests;

require_once '/app/src/Calculatrice.php';
require_once '/app/src/CustomException/DivideByZeroException.php';

use App\Calculatrice;
use App\CustomException\DivideByZeroException;
use Exception;
use PHPUnit\Framework\TestCase;

final class CalculatriceTest extends TestCase
{
    /**
     * @covers \App\Calculatrice::addition
     */
    public function testAddition(): void
    {
        $calculatrice = new Calculatrice();
        $this->assertEquals(4, $calculatrice->addition(2, 2));
    }

    /**
     * @covers \App\Calculatrice::soustraction
     */
    public function testSoustraction(): void
    {
        $calculatrice = new Calculatrice();
        $this->assertEquals(0, $calculatrice->soustraction(2, 2));
    }

    /**
     * @covers \App\Calculatrice::multiplication
     */
    public function testMultiplication(): void
    {
        $calculatrice = new Calculatrice();
        $this->assertEquals(4, $calculatrice->multiplication(2, 2));
    }

    /**
     * @covers \App\Calculatrice::division
     * @throws Exception
     */
    public function testDivision(): void
    {
        $calculatrice = new Calculatrice();
        $this->assertEquals(1, $calculatrice->division(2, 2));
    }

    /**
     * @covers \App\Calculatrice::division
     * @covers \App\CustomException\DivideByZeroException
     * @throws Exception
     */
    public function testDivisionByZero(): void
    {
        $calculatrice = new Calculatrice();
        $this->expectException(DivideByZeroException::class);

        $calculatrice->division(2, 0);
    }
}