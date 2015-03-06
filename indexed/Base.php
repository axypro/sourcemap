<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\indexed;

use axy\sourcemap\parsing\Context;

/**
 * Basic class of indexed section ("sources" and "names")
 */
abstract class Base
{
    /**
     * The constructor
     *
     * @param \axy\sourcemap\parsing\Context $context
     *        the parsing context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
        $key = $this->contextKey;
        $this->names = $context->$key;
        $this->indexes = array_flip($this->names);
    }

    /**
     * Returns the names list
     *
     * @return string[]
     */
    public function getNames()
    {
        return $this->names;
    }

    /**
     * Returns a name by an index (or NULL if index is not found)
     *
     * @param int $index
     * @return string|null
     */
    public function getNameByIndex($index)
    {
        return isset($this->names[$index]) ? $this->names[$index] : null;
    }

    /**
     * Returns an index by a name (or NULL if index is not found)
     *
     * @param string $name
     * @return int
     */
    public function getIndexByName($name)
    {
        return isset($this->indexes[$name]) ? $this->indexes[$name] : null;
    }

    /**
     * Adds a name in the list and returns an index
     * If name is exists then returns its index
     *
     * @param string $name
     * @return int
     *
     */
    public function add($name)
    {
        if (isset($this->indexes[$name])) {
            return $this->indexes[$name];
        }
        $index = count($this->names);
        $this->names[] = $name;
        $this->indexes[$name] = $index;
        return $index;
    }

    /**
     * Renames a name
     *
     * @param int $index
     * @param string $newName
     * @return bool
     */
    public function rename($index, $newName)
    {
        if (!isset($this->names[$index])) {
            return false;
        }
        if ($this->names[$index] === $newName) {
            return false;
        }
        $this->names[$index] = $newName;
        $this->onRename($index, $newName);
        return true;
    }

    /**
     * Renames a item in the mappings
     *
     * @param int $index
     * @param string $newName
     * @return bool
     */
    abstract protected function onRename($index, $newName);

    /**
     * A key from the context (contains the names list)
     * (for override)
     *
     * @var string
     */
    protected $contextKey;

    /**
     * @var string[]
     */
    protected $names;

    /**
     * @var int[]
     */
    protected $indexes;

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    protected $context;
}
