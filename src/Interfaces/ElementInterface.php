<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

use ArrayAccess;
use Countable;
use IteratorAggregate;
use JsonSerializable;

interface ElementInterface extends ArrayAccess, Countable, JsonSerializable, IteratorAggregate
{
    const API_VERSION = 'version';

    const API_OBJECT = 'jsonapi';

    const API_META = 'meta';

    const API_DATA = 'data';

    const API_LINKS = 'links';

    const API_ERRORS = 'errors';

    const API_INCLUDED = 'included';

    const API_RESOURCE_ID = 'id';

    const API_RESOURCE_TYPE = 'type';

    const API_RESOURCE_ATTRIBUTES = 'attributes';

    const API_RELATIONSHIPS = 'relationships';

    /**
     * Get all of the collected items.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Determine if the given value exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool;

    /**
     * Get the value for the specified key.
     *
     * @param  string  $key
     * @param  mixed   $default
     * @return mixed
     */
    public function get(string $key, $default = null);

    /**
     * Set a given key value pair(s).
     *
     * @param  mixed  $value
     * @return static
     */
    public function set($value): ElementInterface;

    /**
     * Remove one or more values for the provided keys.
     *
     * @param  string  $key
     * @return static
     */
    public function del(string $key): ElementInterface;

    /**
     * Remove all key value pair(s).
     *
     * @return static
     */
    public function reset(): ElementInterface;

    /**
     * The resource default value.
     *
     * @return mixed
     */
    public function defaultValue();

    /**
     * The resource object name.
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Determine if the collector is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if the key(s) is allowed on this resource.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function isMember(string $key): bool;

    /**
     * The keys allowed on this resource.
     *
     * @return array
     */
    public function getMembers(): array;

    /**
     * The resource string representation.
     *
     * @return string
     */
    public function toString(): string;

    /**
     * The resource array representation.
     *
     * @return array
     */
    public function toArray(): array;
}
