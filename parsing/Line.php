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
     * @param \axy\sourcemap\PosMap[] $positions [optional]
     *        a list of ordered positions
     */
    public function __construct(array $positions = null)
    {
        $this->positions = $positions ?: [];
    }

    /**
     * Loads the positions list from a numeric array
     *
     * @param \axy\sourcemap\PosMap[] $positions
     * @return \axy\sourcemap\parsing\Line
     */
    public static function loadFromPlainList(array $positions)
    {
        $rPositions = [];
        foreach ($positions as $pos) {
            $rPositions[$pos->generated->line] = $pos;
        }
        return new self($rPositions);
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
     * @var \axy\sourcemap\PosMap[]
     */
    private $positions;
}
