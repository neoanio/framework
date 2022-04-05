<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class MethodNotAllowedHttpException
 *
 * @method int getStatusCode() 405
 *
 * @package Neoan\Framework
 */
class MethodNotAllowedHttpException extends HttpException
{
    /**
     * Create a new 405 Method Not Allowed Http Exception instance.
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
            Response::HTTP_METHOD_NOT_ALLOWED,
            $message ?: Response::$statusTexts[Response::HTTP_METHOD_NOT_ALLOWED],
            $previous,
            $headers,
            $code,
        );
    }
}
