<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class LengthRequiredHttpException
 *
 * @method int getStatusCode() 411
 *
 * @package Neoan\Framework
 */
class LengthRequiredHttpException extends HttpException
{
    /**
     * Create a new 411 Length Required Http Exception instance.
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
            Response::HTTP_LENGTH_REQUIRED,
            $message ?: Response::$statusTexts[Response::HTTP_LENGTH_REQUIRED],
            $previous,
            $headers,
            $code,
        );
    }
}
