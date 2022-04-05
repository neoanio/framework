<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class ConflictHttpException
 *
 * @method int getStatusCode() 409
 *
 * @package Neoan\Framework
 */
class ConflictHttpException extends HttpException
{
    /**
     * Create a new 409 Conflict Http Exception instance.
     *
     * @param  string  $message
     * @param  \Throwable|null  $previous
     * @param  int  $code
     * @param  array  $headers
     */
    public function __construct(
        string $message = '',
        Throwable $previous = null,
        array $headers = [],
        int $code = 0,
    ) {
        parent::__construct(
            Response::HTTP_CONFLICT,
            $message ?: Response::$statusTexts[Response::HTTP_CONFLICT],
            $previous,
            $headers,
            $code,
        );
    }
}
