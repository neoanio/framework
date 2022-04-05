<?php

namespace Neoan\Framework\Routing;

use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;
use Neoan\Framework\Support\Responsable;
use stdClass;

class Router
{
    /**
     * Handle the request.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @return \Neoan\Framework\Http\Response
     */
    public function handle(Request $request) : Response
    {
        $route = new Route($request);

        $response = $route->run();

        return $this->toResponse($request, $response);
    }

    /**
     * Create a response instance from the given value.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @param  \Neoan\Framework\Http\Response|\Neoan\Framework\Support\Responsable|\stdClass|array|string|null  $response
     * @return \Neoan\Framework\Http\Response
     */
    protected function toResponse(
        Request $request,
        Response|Responsable|stdClass|array|string|null $response
    ) : Response {

        if ($response instanceof Responsable) {
            $response = $response->toResponse($request);
        }

        if ($response instanceof stdClass || is_array($response)) {

            $response = new Response(
                content: json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
                headers: ['Content-Type' => 'application/json']
            );
        }

        if (!$response instanceof Response) {

            $response = new Response(
                content: $response,
                headers: ['Content-Type' => 'text/html']
            );
        }

        return $response->prepare($request);
    }
}