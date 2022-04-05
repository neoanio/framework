<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class NotAcceptableHttpException
 *
 * @method int getStatusCode() 406
 *
 * @package Neoan\Framework
 */
class NotAcceptableHttpException extends HttpException
{
    /**
     * Create a new 406 Not Acceptable Http Exception instance.
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
            Response::HTTP_NOT_ACCEPTABLE,
            $message ?: Response::$statusTexts[Response::HTTP_NOT_ACCEPTABLE],
            $previous,
            $headers,
            $code,
        );
    }
}
