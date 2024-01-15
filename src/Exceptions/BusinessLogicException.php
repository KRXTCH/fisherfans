<?php

namespace App\Exception;

use Symfony\Component\HttpKernel\Exception\HttpException;

class BusinessLogicException extends HttpException
{
    public function __construct(string $message = 'Erreur métier', \Exception $previous = null, int $code = 0, array $headers = [])
    {
        parent::__construct(400, $message, $previous, $headers, $code);
    }
}
