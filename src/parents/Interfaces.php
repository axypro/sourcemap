<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\parents;

use Traversable;

/**
 * Partition of the SourceMap class (interfaces implementations)
 */
abstract class Interfaces extends Magic implements \IteratorAggregate, \ArrayAccess, \JsonSerializable, \Serializable
{
    /**
     * {@inheritdoc}
     */
    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->getData());
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset): bool
    {
        return $this->__isset($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function offsetGet($offset)
    {
        return $this->__get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value): void
    {
        $this->__set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset): void
    {
        $this->__unset($offset);
    }

    /**
     * {@inheritdoc}
     */
    #[\ReturnTypeWillChange]
    public function jsonSerialize()
    {
        return $this->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function serialize()
    {
        return serialize($this->__serialize());
    }

    /**
     * {@inheritdoc}
     */
    public function unserialize($serialized)
    {
        $this->__construct(unserialize($serialized));
    }

    /**
     * {@inheritdoc}
     */
    public function __serialize(): array
    {
        $data = $this->getData();
        $data['mappings_serialized'] = $this->context->getMappings();
        return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function __unserialize(array $serialized): void
    {
        $this->__construct($serialized);
    }
}
