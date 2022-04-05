<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class ForbiddenHttpException
 *
 * @method int getStatusCode() 403
 *
 * @package Neoan\Framework
 */
class ForbiddenHttpException extends HttpException
{
    /**
     * Create a new 403 Forbidden Http Exception instance.
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
            Response::HTTP_FORBIDDEN,
            $message ?: Response::$statusTexts[Response::HTTP_FORBIDDEN],
            $previous,
            $headers,
            $code,
        );
    }
}
