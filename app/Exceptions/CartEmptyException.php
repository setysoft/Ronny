<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class CartEmptyException extends Exception
{
    /**
     * FailedToDoCertainAction constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Cart is empty', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
