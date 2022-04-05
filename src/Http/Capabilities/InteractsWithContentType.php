<?php

namespace Neoan\Framework\Http\Capabilities;

trait InteractsWithContentType
{
    /**
     * Determine if the current request accepts any content type.
     *
     * @return bool
     */
    public function acceptsAnyContentType()
    {
        $acceptable = $this->getAcceptableContentTypes();

        return count($acceptable) === 0
            || (isset($acceptable[0]) && ($acceptable[0] === '*/*' || $acceptable[0] === '*'));
    }

    /**
     * Determine if the current request is asking for JSON.
     *
     * @return bool
     */
    public function wantsJson()
    {
        $acceptable = $this->getAcceptableContentTypes();

        if (!isset($acceptable[0])) {
            return false;
        }

        $contentType = strtolower($acceptable[0]);

        return str_contains($contentType, '/json')
            || str_contains($contentType, '+json');
    }
}