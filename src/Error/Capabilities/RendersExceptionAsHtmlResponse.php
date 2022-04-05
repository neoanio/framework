<?php

namespace Neoan\Framework\Error\Capabilities;

use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;
use Throwable;

trait RendersExceptionAsHtmlResponse
{
    /**
     * Convert the exception to a html response
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Neoan\Framework\Http\Response
     */
    protected function toHtml(Request $request, Throwable $exception) : Response
    {
        $content = $this->convertExceptionToView($exception);

        $exception = $this->convertToHttpException($exception);

        $response = new Response(
            content: $content,
            status: $exception->getStatusCode(),
            headers: ['Content-Type' => 'text/html']
        );

        return $response->prepare($request);
    }

    protected function convertExceptionToView(Throwable $exception) : string
    {
        if (config('app.debug')) {

            $whoops = new \Whoops\Run;
            $whoops->allowQuit(false);
            $whoops->writeToOutput(false);
            $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);

            return $whoops->handleException($exception);
        }

        $statusCode = $this->isHttpException($exception)
            ? $exception->getStatusCode()
            : Response::HTTP_INTERNAL_SERVER_ERROR;

        $statusText = Response::$statusTexts[$statusCode];

        // @todo neoan exception handler use template renderer instead of inline html
        return "<html><head><title>{$statusCode} {$statusText}</title></head><body>{$statusCode} {$statusText}</body></html>";
    }
}