<?php

namespace Axsor\LaravelPhpIPAM\Exceptions;

use Exception;
use Throwable;

class PhpIPAMConfigNotFound extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    private function errors($id) {
        $data = [
            'not_found' => [
                "No server connection or file configuration found."
            ]
        ];
        return $data[$id];
    }

    public function __toString()
    {
        return __toString("No server connection or file configuration found.");
    }
}
