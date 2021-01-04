<?php

declare (strict_types = 1);

namespace Org\Jsonapi\Interfaces;

interface DocumentSuccessInterface extends DocumentInterface
{
    /**
     * The document’s “primary data”
     * Primary data MUST be either:
     * 1. a single resource object, a single resource identifier object, or null, for requests that target single resources
     * 2. an array of resource objects, an array of resource identifier objects, or an empty array ([]).
     *
     * @return ElementInterface
     */
    public function getData(): ElementInterface;

    /**
     * The array of resource objects that are related to the primary data and/or each other (“included resources”).
     * If a document does not contain a top-level data key, the included member MUST NOT be present either.
     *
     * @return NodeListInterface
     */
    public function getIncluded(): NodeListInterface;

    /**
     * A links object containing the following members:
     * about: a link that leads to further details about this particular occurrence of the problem.
     *
     * @return LinksInterface
     */
    public function getLinks(): LinksInterface;
}
