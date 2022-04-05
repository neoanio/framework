<?php

namespace Neoan\Framework\Routing\Exceptions;

use Neoan\Framework\Http\Exceptions\NotFoundHttpException;
use Throwable;

class RouteNotFoundException extends NotFoundHttpException
{
    public function __construct(
        string $message = '',
        Throwable $previous = null,
        array $headers = [],
        int $code = 0,
    ) {
        if (!config('app.debug')) {
            $message = '';
        }

        parent::__construct($message, $previous, $headers, $code);
    }
}