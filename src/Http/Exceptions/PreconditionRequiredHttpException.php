<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class PreconditionRequiredHttpException
 *
 * @method int getStatusCode() 428
 *
 * @package Neoan\Framework
 */
class PreconditionRequiredHttpException extends HttpException
{
    /**
     * Create a new 428 Precondition Required Http Exception instance.
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
            Response::HTTP_PRECONDITION_REQUIRED,
            $message ?: Response::$statusTexts[Response::HTTP_PRECONDITION_REQUIRED],
            $previous,
            $headers,
            $code,
        );
    }
}
