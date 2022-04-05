<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class UnsupportedMediaTypeHttpException
 *
 * @method int getStatusCode() 415
 *
 * @package Neoan\Framework
 */
class UnsupportedMediaTypeHttpException extends HttpException
{
    /**
     * Create a new 415 Unsupported Media Type Http Exception instance.
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
            Response::HTTP_UNSUPPORTED_MEDIA_TYPE,
            $message ?: Response::$statusTexts[Response::HTTP_UNSUPPORTED_MEDIA_TYPE],
            $previous,
            $headers,
            $code,
        );
    }
}
