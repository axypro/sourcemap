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
     * Returns a name by a index (or NULL if index is not found)
     *
     * @param int $index
     * @return string|null
     */
    public function getNameByIndex($index)
    {
        return isset($this->names[$index]) ? $this->names[$index] : null;
    }

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
    private $names;

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    private $context;
}
