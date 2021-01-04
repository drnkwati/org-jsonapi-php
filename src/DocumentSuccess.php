<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\DocumentSuccessInterface;
use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\LinksInterface;
use Org\Jsonapi\Interfaces\NodeInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;

class DocumentSuccess extends AbstractDocument implements DocumentSuccessInterface
{
    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return array_merge(parent::getMembers(), [self::API_LINKS, self::API_DATA, self::API_INCLUDED]);
    }

    /**
     * {@inheritdoc }
     */
    public function getData(): ElementInterface
    {
        return ($this->has($key = self::API_DATA) ? $this : $this->setData(new Data))->get($key);
    }

    /**
     * Set the value of the data member
     *
     * @param  ElementInterface $value
     * @return static
     */
    public function setData(ElementInterface $value): NodeInterface
    {
        return $this->put(self::API_DATA, $value);
    }

    /**
     * {@inheritdoc }
     */
    public function getLinks(): LinksInterface
    {
        return ($this->has($key = self::API_LINKS) ? $this : $this->setLinks(new Links))->get($key);
    }

    /**
     * Set the value of the links member
     *
     * @param  LinksInterface $value
     * @return static
     */
    public function setLinks(LinksInterface $value): NodeInterface
    {
        return $this->put(self::API_LINKS, $value);
    }

    /**
     * {@inheritdoc }
     */
    public function getIncluded(): NodeListInterface
    {
        return ($this->has($key = self::API_INCLUDED) ? $this : $this->setIncluded(new Data))->get($key);
    }

    /**
     * Set the value of the included member
     *
     * @param  NodeListInterface $value
     * @return static
     */
    public function setIncluded(NodeListInterface $value): DocumentSuccessInterface
    {
        return $this->put(self::API_INCLUDED, $value);
    }
}
