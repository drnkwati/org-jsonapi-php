<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface RelationInterface extends ResourceInterface
{
    /**
     * The single resource identifier object that references the same resource:
     */
    public function getData(): ResourceIdentifierInterface;

    /**
     * A links object containing the link for the relationship itself:
     *
     * @return LinksInterface
     */
    public function getLinks(): LinksInterface;
}
