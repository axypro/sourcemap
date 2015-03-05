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
     * Packs the mappings
     *
     * @return string
     */
    public function pack()
    {
        $parser = new SegmentParser();
        if ($this->sMappings === null) {
            $ln = [];
            $max = max(array_keys($this->lines));
            for ($i = 0; $i <= $max; $i++) {
                if (isset($this->lines[$i])) {
                    $parser->nextLine($i);
                    $ln[] = $this->lines[$i]->pack($parser);
                } else {
                    $ln[] = '';
                }
            }
            $this->sMappings = implode(';', $ln);
        }
        return $this->sMappings;
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
