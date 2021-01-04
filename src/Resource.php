<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\LinksInterface;
use Org\Jsonapi\Interfaces\NodeInterface;
use Org\Jsonapi\Interfaces\RelationshipsInterface;
use Org\Jsonapi\Interfaces\ResourceInterface;

// Primary data MUST be:
// a single resource object, a single resource identifier object,
// or null, for requests that target single resources

class Resource extends ResourceIdentifier implements ResourceInterface
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
        parent::__construct($id, $type);

        if ($values = array_slice(func_get_args(), 2)) {
            $this->set(...$values);
        }
    }

    /**
     * {@inheritdoc }
     */
    public function set($value): ElementInterface
    {
        $value = func_get_args();

        $pairs = array_filter($value, 'is_array');

        $nodes = array_filter($value, 'is_object');

        if (static::isAssociative($pairs)) {
            parent::set($pairs);
        } elseif ($pairs) {
            $this->getAttributes()->set(call_user_func_array('array_merge', $pairs));
        }

        foreach ($nodes as $node) {
            $this->put($node->getName(), $node);
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return array_merge(
            parent::getMembers(),
            [
                self::API_RESOURCE_ATTRIBUTES, self::API_RELATIONSHIPS, self::API_LINKS
            ]
        );
    }

    /**
     * {@inheritdoc }
     */
    public function getAttributes(): NodeInterface
    {
        return ($this->has($key = self::API_RESOURCE_ATTRIBUTES) ? $this : $this->setAttributes(new Node))->get($key);
    }

    /**
     * Set the value of the attributes member
     *
     * @param  NodeInterface $value
     * @return static
     */
    public function setAttributes(NodeInterface $value): ResourceInterface
    {
        return $this->put(self::API_RESOURCE_ATTRIBUTES, $value);
    }

    /**
     * {@inheritdoc }
     */
    public function getRelationships(): RelationshipsInterface
    {
        return ($this->has($key = self::API_RELATIONSHIPS) ? $this : $this->setRelationships(new Relationships))->get($key);
    }

    /**
     * Set the value of the relationships member
     *
     * @param  RelationshipsInterface $value
     * @return static
     */
    public function setRelationships(RelationshipsInterface $value): ResourceInterface
    {
        return $this->put(self::API_RELATIONSHIPS, $value);
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
}
