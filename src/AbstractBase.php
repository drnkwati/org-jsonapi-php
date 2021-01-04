<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use InvalidArgumentException;

abstract class AbstractBase
{
    /**
     * @param $mixed
     */
    public static function isAssociative($mixed)
    {
        return is_array($mixed) ? array_keys($mixed) !== range(0, count($mixed) - 1) : false;
    }

    /**
     * @param string $value
     * @param string $key
     */
    public static function startsWith(string $value, string $key)
    {
        return substr($value, 0, strlen($key)) === $key;
    }

    /**
     * @param mixed $mixed
     */
    public static function value($mixed)
    {
        return is_callable($mixed) ? call_user_func($mixed) : $mixed;
    }

    /**
     * @return string
     */
    public static function invalidMemberException()
    {
        $arguments = func_get_args();

        array_unshift($arguments, 'You have provided an invalid member. %s:%s');

        throw new InvalidArgumentException(call_user_func_array('sprintf', $arguments));
    }
}
