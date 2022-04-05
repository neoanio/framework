<?php

namespace Neoan\Framework\Container;

use Illuminate\Container\Container as BaseContainer;

class Container extends BaseContainer
{
    protected array $providers;

    /**
     * Resolve the given abstract from the container.
     *
     * @param  string  $abstract
     * @return mixed
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function new(string $abstract)
    {
        return $this->make($abstract);
    }

    public function __get($key)
    {
        return $this->providers[$key];
    }
}