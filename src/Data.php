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
        !$values ?: $this->set(...$values);
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
        $value = func_get_args();

        $nodes = array_filter($value, 'is_object');

        // build more objects from arrays
        foreach (array_filter($value, 'is_array') as $item) {
            $nodes[] = new Resource(array_shift($item), array_shift($item), $item);
        }

        return parent::set($nodes);
    }
}
