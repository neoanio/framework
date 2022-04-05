<?php

use Neoan\Framework\Container\Container;
use Neoan\Framework\Foundation\Application;
use Neoan\Framework\Support\Env;

/**
 * Resolve the given type from the Neoan container.
 *
 * @param  string|null  $abstract
 * @param  array  $parameters
 * @return mixed|\Neoan\Framework\Foundation\Core
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function make(?string $abstract = null, array $parameters = [])
{
    if (is_null($abstract)) {
        return Container::getInstance();
    }

    return Container::getInstance()->make($abstract, $parameters);
}

/**
 * Call the given callable and inject its dependencies.
 *
 * @param  callable|array|string  $callback
 * @param  array<string, mixed>  $parameters
 * @param  string|null  $defaultMethod
 * @return mixed
 */
function call(callable|array|string $callback, array $parameters = [], ?string $defaultMethod = null)
{
    return Container::getInstance()->call($callback, $parameters, $defaultMethod);
}

/**
 * Get the base path of the application installation.
 *
 * @param  string  $path
 * @return string
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 */
function base_path(string $path = '')
{
    return make()->basePath($path);
}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param  array|string|null  $key
 * @param  mixed|null  $default
 * @return mixed|\Neoan\Framework\Config\Manager
 * @throws \Illuminate\Contracts\Container\BindingResolutionException
 * @throws \Psr\Container\ContainerExceptionInterface
 */
function config(array|string|null $key = null, $default = null)
{
    /** @var \Neoan\Framework\Config\Manager $configManager */
    $configManager = make('config');

    if (is_null($key)) {
        return $configManager;
    }

    if (is_array($key)) {
        return $configManager->set($key);
    }

    return $configManager->get($key, $default);
}