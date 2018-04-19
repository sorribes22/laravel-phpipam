<?php

namespace Axsor\LaravelPhpIPAM\Exceptions;


use Exception;
use Throwable;

class PhpIPAMBadCredentials extends Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    private function errors($id) {
        $data = [
            'bad_credentials' => [
                "Bad credentials of PhpIPAM used to connect."
            ]
        ];
        return $data[$id];
    }

    public function __toString()
    {
        return __toString("Bad credentials of PhpIPAM used to connect.");
    }
}