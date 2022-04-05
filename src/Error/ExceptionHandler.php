<?php

namespace Neoan\Framework\Error;

use Exception;
use Neoan\Framework\Console\Application;
use Neoan\Framework\Console\Output;
use Neoan\Framework\Container\Container;
use Neoan\Framework\Error\Capabilities\RendersExceptionAsHtmlResponse;
use Neoan\Framework\Error\Capabilities\RendersExceptionAsJsonResponse;
use Neoan\Framework\Http\Exceptions\InternalServerErrorHttpException;
use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;
use Neoan\Framework\Routing\Exceptions\RouteNotFoundException;
use Neoan\Framework\Support\Responsable;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class ExceptionHandler
{
    use RendersExceptionAsHtmlResponse;
    use RendersExceptionAsJsonResponse;

    /**
     * A list of the exception types that are not reported.
     *
     * @var string[]
     */
    protected array $dontReport = [
        RouteNotFoundException::class,
    ];

    /**
     * Report the exception in the logs.
     *
     * @param  \Throwable  $exception
     */
    public function report(Throwable $exception)
    {
        if (!$this->shouldReport($exception)) {
            return;
        }

        /** @var \Psr\Log\LoggerInterface $logger */
        $logger = Container::getInstance()->make(LoggerInterface::class);

        $logger->error($exception->getMessage(), [
            'exception' => $exception,
        ]);
    }

    /**
     * Make sure the exception should be reported.
     *
     * @param  \Throwable  $exception
     * @return bool
     */
    public function shouldReport(Throwable $exception) : bool
    {
        if (method_exists($exception, 'shouldReport')) {
            return $exception->shouldReport() !== false;
        }

        return empty(array_filter(
            $this->dontReport,
            fn($dontReport) => $exception instanceof $dontReport
        ));
    }

    /**
     * Render the exception to a response.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Neoan\Framework\Http\Response
     */
    public function renderForWeb(Request $request, Throwable $exception) : Response
    {
        if ($exception instanceof Responsable) {
            return $exception->toResponse($request);
        }

        return $request->expectsJson()
            ? $this->toJson($request, $exception)
            : $this->toHtml($request, $exception);
    }

    /**
     * Render the exception in the console.
     *
     * @param  \Neoan\Framework\Console\Application  $app
     * @param  \Neoan\Framework\Console\Output  $output
     * @param  \Throwable  $exception
     */
    public function renderForConsole(Application $app, Output $output, Throwable $exception)
    {
        return $app->renderThrowable($exception, $output);
    }

    /**
     * Determine if the given exception is an HTTP exception.
     *
     * @param  \Throwable  $exception
     * @return bool
     */
    protected function isHttpException(Throwable $exception) : bool
    {
        return $exception instanceof HttpExceptionInterface;
    }

    /**
     * Convert the exception to a http exception
     *
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpKernel\Exception\HttpExceptionInterface
     */
    protected function convertToHttpException(Throwable $exception) : HttpExceptionInterface
    {
        if ($this->isHttpException($exception)) {
            return $exception;
        }

        return new InternalServerErrorHttpException(previous: $exception);
    }
}