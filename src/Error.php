<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\ErrorInterface;
use Org\Jsonapi\Interfaces\LinksInterface;
use Org\Jsonapi\Interfaces\NodeInterface;

// Primary data MUST be:
// a single resource object, a single resource identifier object,
// or null, for requests that target single resources

class Error extends Node implements ErrorInterface
{
    /**
     * @param string $id
     * @param string $type
     * @param array $attributes
     */
    public function __construct(string $title)
    {
        $this->setTitle($title);

        if ($value = array_slice(func_get_args(), 1)) {
            call_user_func_array([$this, 'set'], $value);
        }
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return [
            self::API_RESOURCE_ID, self::API_LINKS,
            'code', 'status', 'title', 'source', 'detail',
            self::API_META
        ];
    }

    /**
     * {@inheritdoc }
     */
    public function getId(): string
    {
        return $this->get(self::API_RESOURCE_ID);
    }

    /**
     * @param string $id
     *
     * @return self
     */
    public function setId(string $id): self
    {
        return $this->put(self::API_RESOURCE_ID, $id);
    }

    /**
     * {@inheritdoc }
     */
    public function getCode(): string
    {
        return $this->get('code');
    }

    /**
     * @param string $code
     *
     * @return self
     */
    public function setCode(string $code): self
    {
        return $this->put('code', $code);
    }

    /**
     * {@inheritdoc }
     */
    public function getStatus(): string
    {
        return $this->get('status');
    }

    /**
     * @param string $status
     *
     * @return self
     */
    public function setStatus(string $status): self
    {
        return $this->put('status', $status);
    }

    /**
     * {@inheritdoc }
     */
    public function getTitle(): string
    {
        return $this->get('title');
    }

    /**
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        return $this->put('title', $title);
    }

    /**
     * {@inheritdoc }
     */
    public function getDetail(): string
    {
        return $this->get('detail');
    }

    /**
     * @param string $detail
     *
     * @return self
     */
    public function setDetail(string $detail): self
    {
        return $this->put('detail', $detail);
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
    public function setLinks(LinksInterface $value): self
    {
        return $this->put(self::API_LINKS, $value);
    }

    /**
     * {@inheritdoc }
     */
    public function getSource(): NodeInterface
    {
        return ($this->has($key = 'source') ? $this : $this->setSource(new Node))->get($key);
    }

    /**
     * Set the value of the source member
     *
     * @param  NodeInterface $value
     * @return static
     */
    public function setSource(NodeInterface $value): self
    {
        return $this->put('source', $value);
    }

    /**
     * {@inheritdoc }
     */
    public function set($value): ElementInterface
    {
        $params = func_get_args();

        $values = array_filter($params, 'is_scalar');

        // merge scaler params
        if (is_array($value) && !static::isAssociative($value)) {
            $values = array_merge($value, $values);
        }
        // First param should be an application-specific error code
        // title was already set during construction
        if ($value = array_shift($values)) {
            $this->setCode((string) $value);
        }

        // other attributes must be provided as key value pairs
        if ($params = array_filter($params, 'static::isAssociative')) {
            $params = call_user_func_array('array_merge', $params);
            !$params ?: parent::set($params);
        }

        return $this;
    }
}
