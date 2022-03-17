<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class FormatNotFoundException extends Exception
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Format '$message' not available", $code, $previous);
    }
}
