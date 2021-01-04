<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use ArrayIterator;
use JsonSerializable;
use Org\Jsonapi\Interfaces\ElementInterface;
use Org\Jsonapi\Interfaces\NodeListInterface;

abstract class AbstractCollector extends AbstractBase
{
    /**
     * All of the items.
     *
     * @var array
     */
    protected $items = [];

    /**
     * {@inheritdoc }
     */
    public function toArray(): array
    {
        return $this->all();
    }

    /**
     * {@inheritdoc }
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * {@inheritdoc }
     */
    public function has(string $key): bool
    {
        return array_key_exists($key, $this->items);
    }

    /**
     * {@inheritdoc }
     */
    public function get(string $key, $default = null)
    {
        return $this->has($key) ? $this->items[$key] : $default;
    }

    /**
     * {@inheritdoc }
     */
    public function set($value): ElementInterface
    {
        is_array($value) ?: $value = func_get_args();

        if ($this instanceof NodeListInterface) {
            foreach ($value as $val) {
                $this->put($val);
            }
        } else {
            if (!static::isAssociative($value)) {
                // if has two args, use one as key and the other as value
                count($value) != 2 ?: $value = [current($value) => end($value)];
            }

            foreach ($value as $key => $val) {
                $key = (string) $key;
                // custom method prefixed with 'set'
                method_exists($this, $setter = 'set' . ucfirst($key)) ?: $setter = null;
                // use a custom method or fallback to put
                // NB: This method must call the put method to avoid recurssive calls
                $setter ? call_user_func([$this, $setter], $val) : $this->put($key, $val);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function del(string $key): ElementInterface
    {
        if ($key == '*') {
            $this->reset();
        } else {
            foreach (func_get_args() as $key) {
                $this->offsetUnset($key);
            }
        }

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function reset(): ElementInterface
    {
        $this->items = [];

        return $this;
    }

    /**
     * {@inheritdoc }
     */
    public function isEmpty(): bool
    {
        return empty($this->items);
    }

    /**
     * {@inheritdoc }
     */
    public function isNotEmpty(): bool
    {
        return !$this->isEmpty();
    }

    /**
     * Count the number of items in the collection.
     *
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_map(function ($item) {
            if ($item instanceof ElementInterface) {
                return $item->jsonSerialize() ?: $item->defaultValue();
            } elseif ($item instanceof JsonSerializable) {
                return $item->jsonSerialize();
            }
            return $item;
        }, $this->items);
    }

    /**
     * Determine if the given item exists.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->has($key);
    }

    /**
     * Get an item.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->get($key);
    }

    /**
     * Set an item.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->set($key, $value);
    }

    /**
     * Unset an item.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->items[$key]);
    }

    /**
     * Get an item from the collector.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->get($key);
    }

    /**
     * Dynamically set the value of an attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return void
     */
    public function __set($key, $value)
    {
        $this->offsetSet($key, $value);
    }

    /**
     * Check if an item is set.
     *
     * @param  string  $key
     * @return bool
     */
    public function __isset($key)
    {
        return !is_null($this->get($key));
    }

    /**
     * Dynamically unset an attribute.
     *
     * @param  string  $key
     * @return void
     */
    public function __unset($key)
    {
        $this->offsetUnset($key);
    }

    /**
     * Get the first item from the collector passing the given truth test.
     *
     * @param  callable|null  $callback
     * @param  mixed  $default
     * @return mixed
     */
    public function first(callable $callback = null, $default = null)
    {
        $items = $this->items;

        if (is_null($callback)) {
            if (empty($items)) {
                return static::value($default);
            }

            foreach ($items as $item) {
                return $item;
            }
        }

        foreach ($items as $key => $value) {
            if (call_user_func($callback, $value, $key)) {
                return $value;
            }
        }

        return static::value($default);
    }

    /**
     * Run a map over each of the items.
     *
     * @param  callable  $callback
     * @return static
     */
    public function map(callable $callback)
    {
        $keys = array_keys($this->items);

        $items = array_map($callback, $this->items, $keys);

        return new static(array_combine($keys, $items));
    }

    /**
     * Transform each item in the collector using a callback.
     *
     * @param  callable  $callback
     * @return $this
     */
    public function transform(callable $callback)
    {
        $this->items = $this->map($callback)->all();

        return $this;
    }
}
