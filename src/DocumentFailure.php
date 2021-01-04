<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\DocumentFailureInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;

class DocumentFailure extends AbstractDocument implements DocumentFailureInterface
{
    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return array_merge(parent::getMembers(), [self::API_ERRORS]);
    }

    /**
     * {@inheritdoc }
     */
    public function getErrors(): NodeListInterface
    {
        return ($this->has($key = self::API_ERRORS) ? $this : $this->setErrors(new Errors))->get($key);
    }

    /**
     * Set the value of the errors member
     *
     * @param  NodeListInterface $value
     * @return static
     */
    public function setErrors(NodeListInterface $value): DocumentFailureInterface
    {
        return $this->put(self::API_ERRORS, $value);
    }
}
