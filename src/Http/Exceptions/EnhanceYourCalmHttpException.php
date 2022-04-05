<?php

namespace Neoan\Framework\Http\Exceptions;

use Neoan\Framework\Http\Response;
use Throwable;

class EnhanceYourCalmHttpException extends HttpException
{
    /**
     * Create a new 420 Gone Http Exception instance.
     *
     * @param  string  $message
     * @param  \Throwable|null  $previous
     * @param  array  $headers
     * @param  int  $code
     */
    public function __construct(
        string $message = '',
        Throwable $previous = null,
        array $headers = [],
        int $code = 0,
    ) {
        parent::__construct(
            Response::HTTP_ENHANCE_YOUR_CALM,
            $message ?: 'Enhance Your Calm',
            $previous,
            $headers,
            $code,
        );
    }
}