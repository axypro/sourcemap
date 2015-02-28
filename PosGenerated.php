<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace ayx\sourcemap;

/**
 * Position in the generated content
 */
class PosGenerated
{
    /**
     * The line number (zero-based)
     *
     * @var int
     */
    public $line;

    /**
     * The column number
     *
     * @var int
     */
    public $column;
}
