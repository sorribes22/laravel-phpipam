<?php

namespace Axsor\PhpIPAM\Exceptions;

use Throwable;

class BadCredentialsException extends \Exception
{
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::construct($message ?: 'Can not connect to PhpIPAM', $code, $previous);
    }
}
