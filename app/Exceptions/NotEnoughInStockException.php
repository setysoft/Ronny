<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class NotEnoughInStockException extends Exception
{
    /**
     * FailedToDoCertainAction constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(string $message = 'Not enough items in the Stock', int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
