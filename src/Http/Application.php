<?php

namespace Neoan\Framework\Http;

use Neoan\Framework\Error\ExceptionHandler;
use Neoan\Framework\Routing\Router;
use Throwable;

class Application
{
    /**
     * Create a new Neoan Http Core instance.
     *
     * @param  \Neoan\Framework\Routing\Router  $router
     * @param  \Neoan\Framework\Error\ExceptionHandler  $exceptionHandler
     */
    public function __construct(
        private Router $router,
        private ExceptionHandler $exceptionHandler,
    ) {
    }

    /**
     * Handle the incoming http request and return a response
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @return \Neoan\Framework\Http\Response
     */
    public function handle(Request $request) : Response
    {
        try {

            $response = $this->sendRequestThroughRouter($request);

        } catch (Throwable $exception) {

            $this->reportException($exception);

            $response = $this->renderException($request, $exception);

        }

        return $response;
    }

    /**
     * Send the request through the router
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @return \Neoan\Framework\Http\Response
     */
    protected function sendRequestThroughRouter(Request $request) : Response
    {
        return $this->router->handle($request);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $exception
     */
    protected function reportException(Throwable $exception)
    {
        $this->exceptionHandler->report($exception);
    }

    /**
     * Render the exception to a response.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Neoan\Framework\Http\Response
     */
    protected function renderException(Request $request, Throwable $exception) : Response
    {
        return $this->exceptionHandler->renderForWeb($request, $exception);
    }
}