<?php

declare (strict_types = 1);

namespace Org\Jsonapi;

use Org\Jsonapi\Interfaces\DocumentInterface;

class Builder extends AbstractBase
{
    /**
     * The jsonapi Document
     *
     * @var DocumentInterface|callable|bool
     */
    protected $document;

    /**
     * @param DocumentInterface|callable|bool $document
     */
    public function __construct($document = true)
    {
        $document instanceof DocumentInterface ?: $document = $this->document($document);

        $this->setDocument($document);
    }

    /**
     * The document string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDocument()->toJson();
    }

    /**
     * @return DocumentInterface
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param DocumentInterface $document
     *
     * @return self
     */
    public function setDocument(DocumentInterface $document): self
    {
        $this->document = $document;

        return $this;
    }

    /**
     * @param  string|callable $method
     * @param  array  $params
     * @return mixed
     */
    public function __call($method, array $params = [])
    {
        $document = $this->getDocument();

        if (is_callable($method)) {
            array_unshift($params, $document);
        } else {
            $method = [$document, $method];
        }

        return call_user_func_array($method, $params);
    }

    /**
     * @param  DocumentInterface|callable|bool $success
     * @return DocumentInterface
     */
    public static function document($success = true)
    {
        !is_callable($success) ?: $success = call_user_func($success);

        return $success ? new DocumentSuccess : new DocumentFailure;
    }

    /**
     * @return NodeListInterface
     */
    public static function data(...$values)
    {
        return new Data(...$values);
    }

    /**
     * @return ErrorInterface
     */
    public static function error(...$values)
    {
        return new Error(...$values);
    }

    /**
     * @return NodeListInterface
     */
    public static function errors(...$values)
    {
        return new Errors(...$values);
    }

    /**
     * @return LinkInterface
     */
    public static function link(...$values)
    {
        return new Link(...$values);
    }

    /**
     * @return LinksInterface
     */
    public static function links(...$values)
    {
        return new Links(...$values);
    }

    /**
     * @return NodeInterface
     */
    public static function node()
    {
        return new Node;
    }

    /**
     * @return NodeListInterface
     */
    public static function nodes()
    {
        return new NodeList;
    }

    /**
     * @return NodeListInterface
     */
    public static function nodeList()
    {
        return static::nodes();
    }

    /**
     * @return RelationInterface
     */
    public static function relation(...$values)
    {
        return new Relation(...$values);
    }

    /**
     * @return RelationshipsInterface
     */
    public static function relations(...$values)
    {
        return new Relationships(...$values);
    }

    /**
     * @return RelationshipsInterface
     */
    public static function relationships(...$values)
    {
        return static::relations(...$values);
    }

    /**
     * @return ResourceInterface
     */
    public static function resource(...$values)
    {
        return new Resource(...$values);
    }

    /**
     * @return ResourceIdentifierInterface
     */
    public static function resourceIdentifier(...$values)
    {
        return new ResourceIdentifier(...$values);
    }

    /**
     * @return ResourceIdentifierInterface
     */
    public static function identifier(...$values)
    {
        return static::resourceIdentifier(...$values);
    }
}
