<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface ResourceInterface extends ResourceIdentifierInterface
{
    /**
     * The value of the attributes key MUST be an object (an “attributes object”).
     *
     * @return NodeInterface
     */
    public function getAttributes(): NodeInterface;

    /**
     * The value of the relationships key MUST be an object (a “relationships object”).
     *
     * @return RelationshipsInterface
     */
    public function getRelationships(): RelationshipsInterface;

    /**
     * Where specified, a links member can be used to represent links.
     *
     * @return LinksInterface
     */
    public function getLinks(): LinksInterface;
}
