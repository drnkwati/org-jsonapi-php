<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\ResourceIdentifierInterface;

// Primary data MUST be:
// a single resource object, a single resource identifier object,
// or null, for requests that target single resources

class ResourceIdentifier extends Node implements ResourceIdentifierInterface
{
    /**
     * Create a new collector.
     *
     * @param string $id
     * @param string $type
     * @return void
     */
    public function __construct($id, string $type)
    {
        $this->setId($id)->setType($type);
    }

    /**
     * {@inheritdoc }
     */
    public function getName(): string
    {
        return self::API_DATA;
    }

    /**
     * {@inheritdoc }
     */
    public function getMembers(): array
    {
        return [self::API_RESOURCE_ID, self::API_RESOURCE_TYPE, self::API_META];
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->get(self::API_RESOURCE_ID);
    }

    /**
     * @param  string $id
     *
     * @return self
     */
    public function setId($id): ResourceIdentifierInterface
    {
        return $this->put(self::API_RESOURCE_ID, (string) $id);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->get(self::API_RESOURCE_TYPE);
    }

    /**
     * @param string $type
     *
     * @return self
     */
    public function setType(string $type): ResourceIdentifierInterface
    {
        return $this->put(self::API_RESOURCE_TYPE, $type);
    }
}
