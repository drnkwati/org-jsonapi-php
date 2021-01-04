<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface DocumentInterface extends NodeInterface
{
    /**
     * Get the version number of jsonapi implementation.
     *
     * @return string
     */
    public function version(): string;

    /**
     * The ducument status code.
     *
     * @return int
     */
    public function getStatusCode(): int;

    /**
     * Set the document's primary data or errors
     *
     * @return DocumentInterface
     */
    // public function collect(array $items): DocumentInterface;

    /**
     * The meta object describing the server’s implementation
     *
     * @return NodeInterface
     */
    public function getJsonapi(): NodeInterface;

    /**
     * Determine if the document has data.
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * Determine if the document has errors.
     *
     * @return bool
     */
    public function isFailure(): bool;
}
