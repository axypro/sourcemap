<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\parsing;

/**
 * Internal context of parsing and change of the source map
 */
class Context
{
    /**
     * The data of the source map file
     *
     * @var array
     */
    public $data;

    /**
     * An array from the "sources" section
     *
     * @var string[]
     */
    public $sources;

    /**
     * An array from the "names" section
     *
     * @var string[]
     */
    public $names;

    /**
     * The constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->sources = isset($data['sources']) ? $data['sources'] : [];
        $this->names = isset($data['names']) ? $data['names'] : [];
    }
}
