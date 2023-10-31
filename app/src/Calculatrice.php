<?php

namespace App;

use App\CustomException\DivideByZeroException;
use Exception;

class Calculatrice
{
    public function addition($a, $b)
    {
        return $a + $b;
    }

    public function soustraction($a, $b)
    {
        return $a - $b;
    }

    public function multiplication($a, $b): float|int
    {
        return $a * $b;
    }

    /**
     * @throws Exception
     */
    public function division($a, $b): float|int
    {
        if ($b === 0) {
            throw new DivideByZeroException();
        }
        return $a / $b;
    }
}