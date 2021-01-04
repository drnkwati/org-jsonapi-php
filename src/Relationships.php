<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\RelationInterface;
use Org\Jsonapi\Interfaces\RelationshipsInterface;

class Relationships extends AbstractNode implements RelationshipsInterface
{
    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_RELATIONSHIPS;
    }

    /**
     * {@inheritdoc }
     */
    public function put(string $key, RelationInterface $value): RelationshipsInterface
    {
        $this->items[$value->getName() ?: $key] = $value;

        return $this;
    }
}
