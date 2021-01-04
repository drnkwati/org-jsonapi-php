<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface RelationshipsInterface extends ElementInterface
{
    /**
     * Set a given key value pair(s).
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return static
     */
    public function put(string $key, RelationInterface $value): RelationshipsInterface;
}
