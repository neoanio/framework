<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class UnauthorizedHttpException
 *
 * @method int getStatusCode() 401
 *
 * @package Neoan\Framework
 */
class UnauthorizedHttpException extends HttpException
{
    /**
     * Create a new 401 Unauthorized Http Exception instance.
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
            Response::HTTP_UNAUTHORIZED,
            $message ?: Response::$statusTexts[Response::HTTP_UNAUTHORIZED],
            $previous,
            $headers,
            $code,
        );
    }
}
