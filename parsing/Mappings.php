<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\parsing;

use axy\sourcemap\PosMap;

/**
 * The "mappings" section
 */
class Mappings
{
    /**
     * The constructor
     *
     * @param string $sMappings
     *        the string from the JSON data
     * @param \axy\sourcemap\parsing\Context $context
     *        the parsing context
     */
    public function __construct($sMappings, Context $context)
    {
        $this->sMappings = $sMappings;
        $this->context = $context;
    }

    /**
     * Returns the list of lines
     *
     * @return \axy\sourcemap\parsing\Line[]
     */
    public function getLines()
    {
        if ($this->lines === null) {
            $this->parse();
        }
        return $this->lines;
    }

    /**
     * Adds a position to the mappings
     *
     * @param \axy\sourcemap\PosMap
     */
    public function addPosition(PosMap $position)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        $generated = $position->generated;
        $nl = $generated->line;
        if (isset($this->lines[$nl])) {
            $this->lines[$nl]->addPosition($position);
        } else {
            $this->lines[$nl] = new Line($nl, [$generated->column => $position]);
        }
        $this->sMappings = null;
    }

    /**
     * Removes a position
     *
     * @param int $line
     *        the generated line number
     * @param int $column
     *        the generated column number
     * @return bool
     *         the position was found and removed
     */
    public function removePosition($line, $column)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        $removed = false;
        if (isset($this->lines[$line])) {
            $l = $this->lines[$line];
            $removed = $l->removePosition($column);
            if ($removed && $l->isEmpty()) {
                unset($this->lines[$line]);
            }
        }
        return $removed;
    }

    /**
     * Parses the mappings string
     */
    private function parse()
    {
        $this->lines = [];
        $parser = new SegmentParser();
        foreach (explode(';', $this->sMappings) as $num => $sLine) {
            $sLine = trim($sLine);
            if ($sLine !== '') {
                $this->lines[$num] = Line::loadFromMappings($num, $sLine, $parser, $this->context);
            }
        }
    }

    /**
     * @var \axy\sourcemap\parsing\Line[]
     */
    private $lines;

    /**
     * @var string
     */
    private $sMappings;

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    private $context;
}
