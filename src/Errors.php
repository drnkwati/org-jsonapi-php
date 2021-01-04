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
        !$values ?: $this->set($values);
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
        if (is_array($value) && !static::isAssociative($value)) {
            return parent::set($value);
        }

        $value = array_map(function ($item) {
            !is_scalar($item) ?: $item = [$item];

            !is_array($item) ?: $item = new Error(array_shift($item), $item);

            return $item;
        }, func_get_args());

        return parent::set($value);
    }
}
