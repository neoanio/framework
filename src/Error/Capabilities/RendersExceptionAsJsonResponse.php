<?php

namespace Neoan\Framework\Error\Capabilities;

use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

trait RendersExceptionAsJsonResponse
{
    /**
     * Convert the exception to a json response
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Neoan\Framework\Http\Response
     */
    protected function toJson(Request $request, Throwable $exception) : Response
    {
        $exception = $this->convertToHttpException($exception);

        $content = $this->convertExceptionToArray($exception);

        $response = new Response(
            content: json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
            status: $exception->getStatusCode(),
            headers: ['Content-Type' => 'application/json']
        );

        return $response->prepare($request);
    }

    protected function convertExceptionToArray(HttpExceptionInterface $exception) : array
    {
        if (!config('app.debug')) {
            return [
                'error' => $exception->getMessage(),
            ];
        }

        $exception = $exception->internalException ?? $exception;

        return [
            'message'   => $exception->getMessage(),
            'exception' => get_class($exception),
            'file'      => $exception->getFile(),
            'line'      => $exception->getLine(),
            'trace'     => array_map(fn($trace) => [
                'class'    => $trace['class'],
                'function' => $trace['function'],
                'file'     => $trace['file'],
                'line'     => $trace['line'],
            ], $exception->getTrace()),
        ];
    }
}