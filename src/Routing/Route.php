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

        // overwrite behaviour for api endpoints
        if ($this->request->hasApiPrefix()) {

            // normalise request method
            $method = strtolower($this->request->getMethod());

            // extract api action from url path
            $apiAction = implode('', array_map(function ($part) {
                return ucfirst(strtolower($part));
            }, explode('-', array_shift($urlParts) ?? '')));

            if (!$apiAction) {
                // default back to action
                $apiAction = $action;
            }

            // overwrite function
            $function = "{$method}{$apiAction}";
        }

        if (!$action) {
            // default back to configurable action
            $action = config('app.default.action', 'Home');
        }

        $controller = $this->resolveController($action);

        // make a callable from controller
        $callable = make($controller);

        // abort if the target method class does not exist on the controller
        if (!method_exists($callable, $function)) {
            throw new RouteNotFoundException("Target method [$function] does not exist on controller [{$controller}].");
        }

        // return the result
        return $callable->{$function}(...$urlParts);
    }

    /**
     * Resolve controller from action
     *
     * @param  string|null  $action
     * @return string
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Psr\Container\ContainerExceptionInterface
     */
    protected function resolveController(?string $action) : string
    {
        // use configurable controller resolver or default back to component controller resolver
        $controllerResolver = config('app.default.controllerResolver', $this->defaultControllerResolver());

        // resolve controller from action
        $controller = $controllerResolver($action);

        // abort if the target controller class does not exist
        if (!class_exists($controller)) {
            throw new RouteNotFoundException("Target class [{$controller}] does not exist.");
        }

        return $controller;
    }

    /**
     * Default component controller resolver callback closure function
     *
     * @return \Closure
     */
    private function defaultControllerResolver() : \Closure
    {
        return fn(string $action) => "\\App\\Component\\{$action}\\{$action}Controller";
    }
}