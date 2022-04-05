<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class InternalServerErrorHttpException
 *
 * @method int getStatusCode() 400
 *
 * @package Neoan\Framework
 */
class InternalServerErrorHttpException extends HttpException
{
    /**
     * Create a new 500 Internal Server Error Http Exception instance.
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
            Response::HTTP_INTERNAL_SERVER_ERROR,
            $message ?: Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR],
            $previous,
            $headers,
            $code,
        );
    }
}
