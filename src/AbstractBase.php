<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use InvalidArgumentException;

abstract class AbstractBase
{
    // 200 Indicates that request has succeeded.
    const API_OK = 200;

    // 201 Indicates that request has succeeded and a new resource has been created as a result.
    const API_CREATED = 201;
    /*
     * 202 Indicates that the request has been received but not completed yet.
     * It is typically used in log running requests and batch processing.
     */
    const API_ACCEPTED = 202;

    /*
     * 204 The server has fulfilled the request but does not need to return a response body.
     * The server may return the updated meta information.
     */
    const API_NO_CONTENT = 204;

    /*
     * 400 The request could not be understood by the server due to incorrect syntax.
     * The client SHOULD NOT repeat the request without modifications.
     * example: input validation failure
     */
    const API_BAD_REQUEST = 400;

    // 404 The server can not find the requested resource.
    const API_NOT_FOUND = 404;

    // 500 A generic REST API error response. A 500 error is never the client’s fault
    const API_SERVER_ERROR = 500;

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
