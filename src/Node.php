<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\NodeInterface;
use StdClass;

class Node extends AbstractNode implements NodeInterface
{
    /**
     * {@inheritdoc }
     */
    public function defaultValue()
    {
        return new StdClass;
    }

    /**
     * {@inheritdoc }
     */
    public function put(string $key, $value): NodeInterface
    {
        !$this->isMember($key) ?: $this->items[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function getMeta(): NodeInterface
    {
        return ($this->has($key = self::API_META) ? $this : $this->setMeta(new Node))->get($key);
    }

    /**
     * Set the value of the meta member
     *
     * @param  NodeInterface $value
     * @return static
     */
    public function setMeta(NodeInterface $value): self
    {
        return $this->put(self::API_META, $value);
    }
}
