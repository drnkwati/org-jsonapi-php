<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\LinkInterface;
use Org\Jsonapi\Interfaces\LinksInterface;
use Org\Jsonapi\Interfaces\NodeInterface;

class Links extends Node implements LinksInterface
{
    /**
     * @param LinkInterface|['self'=>'http://uri'] $values
     */
    public function __construct()
    {
        if ($params = func_get_args()) {
            call_user_func_array([$this, 'set'], $params);
        }
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_LINKS;
    }

    /**
     * {@inheritdoc }
     */
    public function put(string $key, $value): NodeInterface
    {
        call_user_func(function (LinkInterface $value) {}, $value);

        return parent::put($key, $value);
    }

    /**
     * @param  mixed $value
     * @return static
     */
    public function set($value): ElementInterface
    {
        $value = array_map(function ($item) {
            if (is_array($item)) {
                if (static::isAssociative($item)) {
                    $item = new Link(current($item), key($item), $item);
                } else {
                    $item = new Link(...$item);
                }
            }
            return $item;
        }, func_get_args());

        foreach ($value as $item) {
            $this->put($item->getName(), $item);
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function setLink(string $key, $url): LinksInterface
    {
        if (is_string($url) || is_object($url)) {
            !static::startsWith($key, 'set') ?: $key = strtolower(ltrim($key, 'set'));

            $this->set($url instanceof LinkInterface ? $url->setName($key) : [$key, $url]);
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function setSelf($url): LinksInterface
    {
        return $this->setLink(__FUNCTION__, $url);
    }

    /**
     * {@inheritdoc }
     */
    public function setNext($url): LinksInterface
    {
        return $this->setLink(__FUNCTION__, $url);
    }

    /**
     * {@inheritdoc }
     */
    public function setPrev($url): LinksInterface
    {
        return $this->setLink(__FUNCTION__, $url);
    }

    /**
     * {@inheritdoc }
     */
    public function setLast($url): LinksInterface
    {
        return $this->setLink(__FUNCTION__, $url);
    }

    /**
     * {@inheritdoc }
     */
    public function setFirst($url): LinksInterface
    {
        return $this->setLink(__FUNCTION__, $url);
    }
}
