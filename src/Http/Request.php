<?php

namespace Neoan\Framework\Http;

use Neoan\Framework\Http\Capabilities\InteractsWithContentType;
use Symfony\Component\HttpFoundation\Request as BaseRequest;

class Request extends BaseRequest
{
    use InteractsWithContentType;

    /**
     * Create a new Neoan Http Request instance.
     *
     * @param  array  $query  The GET parameters
     * @param  array  $body  The POST parameters
     * @param  array  $attributes  The request attributes (i.e. parameters parsed from the PATH_INFO, etc.)
     * @param  array  $cookies  The COOKIE parameters
     * @param  array  $files  The FILES parameters
     * @param  array  $server  The SERVER parameters
     * @param  string|resource|null  $content  The raw body data
     */
    public function __construct(
        array $query = [],
        array $body = [],
        array $attributes = [],
        array $cookies = [],
        array $files = [],
        array $server = [],
        $content = null
    ) {
        $this->initialize($query, $body, $attributes, $cookies, $files, $server, $content);
    }

    /**
     * Determine if the route is an api route (indicated by its prefix)
     *
     * @return false|int
     */
    public function hasApiPrefix() : int|false
    {
        return preg_match('/api\.(.*)$/', $this->getPathInfo());
    }

    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson()
    {
        return $this->wantsJson()
            || ($this->acceptsAnyContentType() && $this->isXmlHttpRequest())
            || $this->hasApiPrefix();
    }
}