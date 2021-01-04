<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\LinkInterface;

class Link extends Node implements LinkInterface
{
    /**
     * The root resource name
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new link.
     *
     * @param string $name
     * @param string $url
     * @param array  $meta
     *
     * @return void
     */
    public function __construct(string $name, string $url, array $meta = [])
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $this->setHref($url)->setName($name);
        } else {
            $this->setHref($name)->setName($url);
        }

        unset($meta[$name], $meta[$url]);

        !$meta ?: $this->getMeta()->set($meta);
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return ['href', self::API_META];
    }

    /**
     * {@inheritdoc }
     */
    public function setHref(string $url): LinkInterface
    {
        return $this->put('href', $url);
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * {@inheritdoc }
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function jsonSerialize()
    {
        $url = $this->get('href');

        return $url && count($this) == 1 ? $url : parent::jsonSerialize();
    }
}
