<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface NodeInterface extends ElementInterface
{
    /**
     * Set a given key value pair(s).
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return static
     */
    public function put(string $key, $value): NodeInterface;

    /**
     * The meta member can be used to include non-standard meta-information.
     *
     * @return NodeInterface
     */
    public function getMeta(): NodeInterface;
}
