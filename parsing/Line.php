<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\parsing;

/**
 * A line in the generated content
 */
class Line
{
    /**
     * The constructor
     *
     * @param int $num
     *        the line number
     * @param \axy\sourcemap\PosMap[] $positions [optional]
     *        a list of ordered positions
     */
    public function __construct($num, array $positions = null)
    {
        $this->num = $num;
        $this->positions = $positions ?: [];
    }

    /**
     * Loads the positions list from a numeric array
     *
     * @param int $num
     * @param \axy\sourcemap\PosMap[] $positions
     * @return \axy\sourcemap\parsing\Line
     */
    public static function loadFromPlainList($num, array $positions)
    {
        $rPositions = [];
        foreach ($positions as $pos) {
            $rPositions[$pos->generated->column] = $pos;
        }
        return new self($num, $rPositions);
    }

    /**
     * Returns the line number
     *
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * Returns the positions list
     *
     * @return \axy\sourcemap\PosMap[]
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * @var int
     */
    private $num;

    /**
     * @var \axy\sourcemap\PosMap[]
     */
    private $positions;
}
