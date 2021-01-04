<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface DocumentFailureInterface extends DocumentInterface
{
    /**
     * The error objects
     *
     * @return NodeListInterface
     */
    public function getErrors(): NodeListInterface;
}
