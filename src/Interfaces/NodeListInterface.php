<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface NodeListInterface extends ElementInterface
{
    /**
     * Get and remove the last item from the collection.
     *
     * @return mixed
     */
    public function pop();

    /**
     * Set a given key value pair(s).
     *
     * @param  ElementInterface  $value
     * @return static
     */
    public function put(ElementInterface $value): NodeListInterface;

    /**
     * Push an item onto the end of the collection.
     *
     * @param  mixed  $value
     * @return static
     */
    public function push($value): NodeListInterface;

    /**
     * Push an item onto the beginning of the collection.
     *
     * @param  mixed  $value
     * @param  mixed  $key
     * @return static
     */
    public function prepend($value): NodeListInterface;
}
