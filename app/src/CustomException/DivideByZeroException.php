<?php

namespace App\CustomException;

use Exception;

class DivideByZeroException extends Exception
{
    public function __construct()
    {
        parent::__construct('Division by zero');
    }
}