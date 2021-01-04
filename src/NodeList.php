<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;

class NodeList extends AbstractNode implements NodeListInterface
{
    /**
     * {@inheritdoc }
     */
    public function defaultValue()
    {
        return [];
    }

    /**
     * {@inheritdoc }
     */
    public function put(ElementInterface $value): NodeListInterface
    {
        !$this->isMember($value->getName()) ?: $this->items[] = $value;

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function pop()
    {
        return array_pop($this->items);
    }

    /**
     * {@inheritdoc }
     */
    public function push($value): NodeListInterface
    {
        foreach (is_array($value) ? $value : func_get_args() as $value) {
            $this->put($value);
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function prepend($value): NodeListInterface
    {
        $items = $this->items;

        $this->reset();

        foreach (array_reverse(is_array($value) ? $value : func_get_args()) as $value) {
            $this->put($value);
        }

        return $this->set($items);
    }
}
