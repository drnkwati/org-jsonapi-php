<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ElementInterface;

abstract class AbstractNode extends AbstractCollector implements ElementInterface
{
    /**
     * The json encode options
     *
     * @var int
     */
    protected $jsonOptions = 0;

    /**
     * {@inheritdoc }
     */
    public function defaultValue()
    {
        return null;
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return '';
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return ['*'];
    }

    /**
     * {@inheritdoc }
     */
    public function isMember(string $key): bool
    {
        $keys = $this->getMembers();

        $hasMember = function (string $key) use ($keys) {
            if (in_array('*', $keys) || (in_array($key, $keys) && !is_null($key))) {
                return true;
            }
            // if ($key !== null) {
            //     if (in_array('*', $keys) && !in_array($key, $keys)) {
            //         return true;
            //     } elseif (!in_array('*', $keys) && in_array($key, $keys)) {
            //         return true;
            //     }
            // }
            return false;
        };

        foreach (array_filter(func_get_args(), 'is_string') as $key) {
            if ($hasMember($key) == false) {return false;}
        }

        return true;
    }

    /**
     * Determine if the key(s) is allowed on this resource.
     *
     * @param  string  $key
     *
     * @return bool
     */
    public function isFillable(string $key): bool
    {
        return call_user_func_array([$this, 'isMember'], func_get_args());
    }

    /**
     * {@inheritdoc }
     */
    public function toString(): string
    {
        return $this->toJson();
    }

    /**
     * {@inheritdoc }
     */
    public function toJson(): string
    {
        // return json_encode($this->toPayload(), $this->getJsonOptions());
        return json_encode($this->jsonSerialize(), $this->getJsonOptions());
    }

    /**
     * {@deprecated }
     */
    // public function toPayload(): array
    // {
    //     $key = $this->getName();

    //     $value = $this->jsonSerialize();

    //     return $key ? [$key => $value] : $value;
    // }

    /**
     * @return int
     */
    public function getJsonOptions(): int
    {
        return $this->jsonOptions;
    }

    /**
     * @param int $jsonOptions
     *
     * @return self
     */
    public function setJsonOptions(int $jsonOptions): self
    {
        $this->jsonOptions = $jsonOptions;

        return $this;
    }
}
