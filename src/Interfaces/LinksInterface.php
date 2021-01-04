<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface LinksInterface extends NodeInterface
{
    /**
     * Set the current resource url.
     *
     * @param  string|LinksInterface  $value
     *
     * @return static
     */
    public function setSelf($value): LinksInterface;

    /**
     * Set the next resource url.
     *
     * @param  string|LinksInterface  $value
     *
     * @return static
     */
    public function setNext($value): LinksInterface;

    /**
     * Set the previous resource url.
     *
     * @param  string|LinksInterface  $value
     *
     * @return static
     */
    public function setPrev($value): LinksInterface;

    /**
     * Set the last resource url.
     *
     * @param  string|LinksInterface  $value
     *
     * @return static
     */
    public function setLast($value): LinksInterface;
}

/**
"links": {
"self": "http://example.com/posts"
"related": {
"href": "http://example.com/articles/1/comments",
"meta": {
"count": 10
}
}
}
 */
