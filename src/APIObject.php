<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

class APIObject extends Node
{
    /**
     * {@inheritdoc }
     */
    protected $items = [self::API_VERSION => '1.0'];

    public function __construct()
    {
        $this->getMeta()->set('spec', 'https://jsonapi.org');
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_OBJECT;
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return [self::API_VERSION, self::API_META];
    }
}
