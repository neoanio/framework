<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class UnprocessableEntityHttpException
 *
 * @method int getStatusCode() 422
 *
 * @package Neoan\Framework
 */
class UnprocessableEntityHttpException extends HttpException
{
    /**
     * Create a new 422 Unprocessable Entity Http Exception instance.
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
            Response::HTTP_UNPROCESSABLE_ENTITY,
            $message ?: Response::$statusTexts[Response::HTTP_UNPROCESSABLE_ENTITY],
            $previous,
            $headers,
            $code,
        );
    }
}
