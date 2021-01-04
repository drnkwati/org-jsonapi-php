<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;
use Org\Jsonapi\Interfaces\ResourceInterface;

// Primary data MUST be:
// an array of resource objects, an array of resource identifier objects,
// or an empty array ([]), for requests that target resource collections

class Data extends NodeList
{
    /**
     * @param ResourceInterface $values
     * @return void
     */
    public function __construct(ResourceInterface...$values)
    {
        !$values ?: $this->set($values);
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_DATA;
    }

    /**
     * {@inheritdoc }
     */
    public function put(ElementInterface $value): NodeListInterface
    {
        call_user_func(function (ResourceInterface $value) {}, $value);

        return parent::put($value);
    }

    /**
     * {@inheritdoc }
     */
    public function set($value): ElementInterface
    {
        if (is_array($value) && !static::isAssociative($value)) {
            return parent::set($value);
        }

        $value = array_map(function ($item) {
            return is_array($item) ? new Resource(array_shift($item), array_shift($item), $item) : $item;
        }, func_get_args());

        return parent::set($value);
    }
}
