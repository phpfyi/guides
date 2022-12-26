<?php

namespace PhpFyi;

use Closure;
use DOMDocument;
use DOMNode;

abstract class XMLService
{
    protected $dom;

    protected $root;

    protected $pages = [];

    public function __construct()
    {
        $this->dom = new DOMDocument('1.0', "UTF-8");
        $this->dom->formatOutput = true;
    }

    abstract public function createEntry(DOMNode $parent, object $page): void;

    public function setPages(array $pages): static
    {
        $this->pages = $pages;
        return $this;
    }

    public function getXML(): string
    {
        array_map(
            fn (object $page) => $this->createEntry($this->root, $page),
            $this->pages
        );
        $this->dom->appendChild($this->root);

        return $this->dom->saveXML();
    }

    protected function root(string $tag, array $attributes): DOMNode
    {
        $this->root = $this->dom->createElement($tag);

        return $this->attributes($this->root, $attributes);
    }

    protected function element(DOMNode $parent, string $name, string $value, Closure $callback = null): static
    {
        $parent->appendChild(
            $node = $this->dom->createElement($name, htmlspecialchars($value))
        );
        if ($callback) {
            $callback($node);
        }
        return $this;
    }

    protected function attributes(DOMNode $node, array $attributes): DOMNode
    {
        foreach ($attributes as $name => $value) {
            $attribute = $this->dom->createAttribute($name);
            $attribute->value = $value;
            $node->appendChild($attribute);
        }
        return $node;
    }
}
