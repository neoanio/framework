<?php

namespace Neoan\Framework\Support;

use Neoan\Framework\Http\Request;
use Neoan\Framework\Http\Response;

interface Responsable
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param  \Neoan\Framework\Http\Request  $request
     * @return \Neoan\Framework\Http\Response|stdClass|array|string|null
     */
    public function toResponse(Request $request) : Response|stdClass|array|string|null;
}