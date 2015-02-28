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
     * The constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }
}
