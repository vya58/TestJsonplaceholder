<?php

namespace App\Src\Exceptions;

class ErrorException
{
    public int $code;
    public string $message;

    public function __construct(int $code, string $message = 'Произошла ошибка')
    {
        $this->code = $code;
        $this->message = $message;
    }
}
