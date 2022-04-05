<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class GoneHttpException
 *
 * @method int getStatusCode() 410
 *
 * @package Neoan\Framework
 */
class GoneHttpException extends HttpException
{
    /**
     * Create a new 410 Gone Http Exception instance.
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
            Response::HTTP_GONE,
            $message ?: Response::$statusTexts[Response::HTTP_GONE],
            $previous,
            $headers,
            $code,
        );
    }
}
