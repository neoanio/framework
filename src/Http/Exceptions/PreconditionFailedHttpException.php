<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class PreconditionFailedHttpException
 *
 * @method int getStatusCode() 412
 *
 * @package Neoan\Framework
 */
class PreconditionFailedHttpException extends HttpException
{
    /**
     * Create a new 412 Precondition Failed Http Exception instance.
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
            Response::HTTP_PRECONDITION_FAILED,
            $message ?: Response::$statusTexts[Response::HTTP_PRECONDITION_FAILED],
            $previous,
            $headers,
            $code,
        );
    }
}
