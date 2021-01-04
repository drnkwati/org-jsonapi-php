<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\RelationInterface;
use Org\Jsonapi\Interfaces\ResourceIdentifierInterface;

class Relation extends Resource implements RelationInterface
{
    /**
     * Create a new collector.
     *
     * @param string $id
     * @param string $type
     * @return void
     */
    public function __construct($id, string $type)
    {
        $this->setData(new ResourceIdentifier($id, $type));
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return [self::API_LINKS, self::API_DATA];
    }

    /**
     * {@inheritdoc }
     */
    public function getData(): ResourceIdentifierInterface
    {
        $key = self::API_DATA;

        if (!$this->has($key) && $params = func_get_args()) {
            $this->setData(new ResourceIdentifier(...$params));
        }

        return $this->get($key);
    }

    /**
     * Set the value of the data member
     *
     * @param  ResourceIdentifierInterface $value
     * @return static
     */
    public function setData(ResourceIdentifierInterface $value): RelationInterface
    {
        return $this->put(self::API_DATA, $value);
    }
}
