<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\ErrorInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;

class Errors extends NodeList
{
    /**
     * @param ErrorInterface $values
     */
    public function __construct(ErrorInterface...$values)
    {
        !$values ?: $this->set(...$values);
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_ERRORS;
    }

    /**
     * {@inheritdoc }
     */
    public function put(ElementInterface $value): NodeListInterface
    {
        call_user_func(function (ErrorInterface $value) {}, $value);

        return parent::put($value);
    }

    /**
     * {@inheritdoc }
     */
    public function set($value): ElementInterface
    {
        if ($value = func_get_args()) {
            $nodes = array_filter($value, 'is_object');

            $pairs = array_filter($value, 'is_array');

            // build more arrays from strings
            foreach (array_filter($value, 'is_scalar') as $item) {
                $pairs[] = [$item];
            }

            // build more objects from arrays
            foreach ($pairs as $item) {
                $nodes[] = new Error(...$item);
            }

            parent::set($nodes);
        }

        return $this;
    }
}
