<?php

namespace App\CustomException;

use Exception;

class EmailNotSentException extends Exception
{
    public function __construct(string $message = 'Email not sent', int $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}