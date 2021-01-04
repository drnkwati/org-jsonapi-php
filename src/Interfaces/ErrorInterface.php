<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface ErrorInterface extends NodeInterface
{
    /**
     * The unique identifier for this particular occurrence of the problem.
     *
     * @return string
     */
    public function getId(): string;

    /**
     * An application-specific error code, expressed as a string value.
     */
    public function getCode(): string;

    /**
     *  The HTTP status code applicable to this problem, expressed as a string value.
     *
     * @return string
     */
    public function getStatus(): string;

    /**
     * A short, human-readable summary of the problem that SHOULD NOT change from occurrence to occurrence.
     * This field’s value can be localized.
     *
     * @return string
     */
    public function getTitle(): string;

    /**
     * A human-readable explanation specific to this occurrence of the problem.
     * Like title, this field’s value can be localized.
     *
     * @return string
     */
    public function getDetail(): string;

    /**
     * A links object containing the following members:
     * about: a link that leads to further details about this particular occurrence of the problem.
     *
     * @return LinksInterface
     */
    public function getLinks(): LinksInterface;

    /**
     * An object containing references to the source of the error.
     *
     * @return NodeInterface
     */
    public function getSource(): NodeInterface;
}
