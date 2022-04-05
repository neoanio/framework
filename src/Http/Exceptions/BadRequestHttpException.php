<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class BadRequestHttpException
 *
 * @method int getStatusCode() 400
 *
 * @package Neoan\Framework
 */
class BadRequestHttpException extends HttpException
{
    /**
     * Create a new 400 Bad Request Http Exception instance.
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
            Response::HTTP_BAD_REQUEST,
            $message ?: Response::$statusTexts[Response::HTTP_BAD_REQUEST],
            $previous,
            $headers,
            $code,
        );
    }
}
