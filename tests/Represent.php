<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests;

use axy\sourcemap\PosMap;
use axy\sourcemap\parsing\Line;

/**
 * Representation of the library objects as arrays for tests
 */
class Represent
{
    /**
     * @param \axy\sourcemap\PosMap $pos
     * @return array
     */
    public static function posMap(PosMap $pos)
    {
        return [
            'generated' => (array)$pos->generated,
            'source' => (array)$pos->source,
        ];
    }

    /**
     * @param \axy\sourcemap\parsing\Line $line
     * @return array
     */
    public static function line(Line $line)
    {
        $result = [];
        foreach ($line->getPositions() as $column => $position) {
            $result[$column] = self::posMap($position);
        }
        return $result;
    }
}
