<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

/**
 * Class PaymentRequiredHttpException
 *
 * @method int getStatusCode() 402
 *
 * @package Neoan\Framework
 */
class PaymentRequiredHttpException extends HttpException
{
    /**
     * Create a new 402 Payment Required Http Exception instance.
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
            Response::HTTP_PAYMENT_REQUIRED,
            $message ?: Response::$statusTexts[Response::HTTP_PAYMENT_REQUIRED],
            $previous,
            $headers,
            $code,
        );
    }
}
