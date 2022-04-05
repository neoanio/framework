<?php

namespace Neoan\Framework\Routing;

use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;
use Neoan\Framework\Routing\Exceptions\RouteNotFoundException;
use Neoan\Framework\Support\Responsable;

class Route
{
    /**
     * Create a new Neoan Routing Route instance.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     */
    public function __construct(
        protected Request $request
    ) {
    }

    /**
     * Run the route logic.
     *
     * @return \Neoan\Framework\Http\Response|\Neoan\Framework\Support\Responsable|\Neoan\Framework\Routing\stdClass|array|string|null
     */
    public function run() : Response|Responsable|stdClass|array|string|null
    {
        $urlPath = $this->request->getPathInfo();

        $urlParts = explode('/', trim($urlPath ?? '', '/'));

        // extract action from url path
        $action = implode('', array_map(function ($part) {
            return ucfirst(strtolower($part));
        }, explode('-', array_shift($urlParts) ?? '')));

        $function = config('app.default.function', 'init');

        if ($this->request->expectsJson()) {

            $method = strtolower($this->request->getMethod());

            // extract action from url path
            $action = implode('', array_map(function ($part) {
                return ucfirst(strtolower($part));
            }, explode('-', array_shift($urlParts) ?? '')));

            $function = "{$method}{$action}";

        }

        $action = $action ?: config('app.default.action', 'Home');

        // @todo neoan router allow guessing strategy
        $controller = "\\App\\Component\\{$action}\\{$action}Controller";

        if (!class_exists($controller)) {
            throw new RouteNotFoundException("Target class [{$controller}] does not exist.");
        }

        $callable = make($controller);

        $parameters = $urlParts;

        if (!method_exists($callable, $function)) {
            throw new RouteNotFoundException("Target method [$function] does not exist on controller [{$controller}].");
        }

        return $callable->{$function}(...$parameters);

    }
}