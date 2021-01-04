<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface ResourceIdentifierInterface extends NodeInterface
{
    /**
     * The unique identifier for this resource.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * The resource type
     *
     * @return string
     */
    public function getType(): string;
}
