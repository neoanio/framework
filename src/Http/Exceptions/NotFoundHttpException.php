<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class NotFoundHttpException
 *
 * @method int getStatusCode() 404
 *
 * @package Neoan\Framework
 */
class NotFoundHttpException extends HttpException
{
    /**
     * Create a new 404 Not Found Http Exception instance.
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
            Response::HTTP_NOT_FOUND,
            $message ?: Response::$statusTexts[Response::HTTP_NOT_FOUND],
            $previous,
            $headers,
            $code,
        );
    }
}
