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
        $value = func_get_args();

        $pairs = array_filter($value, 'is_array');

        $nodes = array_filter($value, 'is_object');

        if ($nodes && !static::isAssociative($nodes)) {
            parent::set($nodes);
        }

        // conver text to pairs
        foreach (array_filter($value, 'is_scalar') as $item) {
            $pairs[] = [$item];
        }

        if ($pairs) {
            parent::set(array_map(function ($msg) {return new Error(...$msg);}, $pairs));
        }

        return $this;
    }
}
