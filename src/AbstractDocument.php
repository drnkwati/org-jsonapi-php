<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\DocumentFailureInterface;
use Org\Jsonapi\Interfaces\DocumentInterface;
use Org\Jsonapi\Interfaces\DocumentSuccessInterface;
use Org\Jsonapi\Interfaces\NodeInterface;

abstract class AbstractDocument extends Node implements DocumentInterface
{
    /**
     * The ducument status code.
     *
     * @var int
     */
    protected $statusCode = 200;

    public function __construct()
    {
        $this->getJsonapi();
    }

    /**
     * {@inheritdoc }
     */
    public function isSuccess(): bool
    {
        return $this instanceof DocumentSuccessInterface;
    }

    /**
     * {@inheritdoc }
     */
    public function isFailure(): bool
    {
        return $this instanceof DocumentFailureInterface;
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return ['jsonapi', 'meta'];
    }

    /**
     * {@inheritdoc }
     */
    public function version(): string
    {
        return $this->getJsonapi()->get('version');
    }

    /**
     * {@inheritdoc }
     */
    public function getJsonapi(): NodeInterface
    {
        return ($this->has($key = 'jsonapi') ? $this : $this->set([$key => new APIObject]))->get($key);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     *
     * @return self
     */
    public function setStatusCode($statusCode): DocumentInterface
    {
        is_null($statusCode) ?: $this->statusCode = (int) $statusCode;

        return $this;
    }
}
