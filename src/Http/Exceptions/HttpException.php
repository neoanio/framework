<?php

namespace Neoan\Framework\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException as BaseHttpException;

abstract class HttpException extends BaseHttpException
{
    public ?\Throwable $internalException;

    public function __construct(int $statusCode, string $message = '', \Throwable $previous = null, array $headers = [], int $code = 0)
    {
        $this->internalException = $previous;

        parent::__construct($statusCode, $message, $previous, $headers, $code);
    }
}