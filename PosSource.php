<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap;

/**
 * Position in the source
 */
class PosSource
{
    /**
     * A source file as an index in the "sources" section
     *
     * @var int
     */
    public $fileIndex;

    /**
     * A source file name
     *
     * @var string
     */
    public $fileName;

    /**
     * A line number (zero-based)
     *
     * @var int
     */
    public $line;

    /**
     * A column number (zero-based)
     *
     * @var int
     */
    public $column;

    /**
     * A symbol name as an index in the "names" section
     *
     * @var int
     */
    public $nameIndex;

    /**
     * A symbol name
     *
     * @var string
     */
    public $name;
}
