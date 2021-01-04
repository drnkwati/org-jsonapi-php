<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface LinkInterface extends NodeInterface
{
    /**
     * The string containing the link’s URL.
     *
     * @param string $url
     *
     * @return static
     */
    public function setHref(string $url): LinkInterface;
}

/*
"links": {
"related": {
"href": "http://example.com/articles/1/comments",
"meta": {
"count": 10
}
}
}
 */
