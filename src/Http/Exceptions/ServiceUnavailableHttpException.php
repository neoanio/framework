<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class ServiceUnavailableHttpException
 *
 * @method int getStatusCode() 503
 *
 * @package Neoan\Framework
 */
class ServiceUnavailableHttpException extends HttpException
{
    /**
     * Create a new 503 Service Unavailable Http Exception instance.
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
            Response::HTTP_SERVICE_UNAVAILABLE,
            $message ?: Response::$statusTexts[Response::HTTP_SERVICE_UNAVAILABLE],
            $previous,
            $headers,
            $code,
        );
    }
}
