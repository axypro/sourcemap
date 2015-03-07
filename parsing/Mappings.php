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
        if ($removed) {
            $this->sMappings = null;
        }
        return $removed;
    }

    /**
     * Renames a file name
     *
     * @param int $fileIndex
     * @param string $newFileName
     */
    public function renameFile($fileIndex, $newFileName)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        foreach ($this->lines as $line) {
            $line->renameFile($fileIndex, $newFileName);
        }
    }

    /**
     * Renames a symbol name
     *
     * @param int $nameIndex
     * @param string $newName
     */
    public function renameName($nameIndex, $newName)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        foreach ($this->lines as $line) {
            $line->renameName($nameIndex, $newName);
        }
    }

    /**
     * Removes a file
     *
     * @param int $fileIndex
     * @return bool
     */
    public function removeFile($fileIndex)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        $removed = false;
        $lines = $this->lines;
        foreach ($lines as $ln => $line) {
            if ($line->removeFile($fileIndex)) {
                $removed = true;
                if ($line->isEmpty()) {
                    unset($this->lines[$ln]);
                }
            }
        }
        $this->sMappings = null;
        return $removed;
    }

    /**
     * Removes a name
     *
     * @param int $nameIndex
     * @return bool
     */
    public function removeName($nameIndex)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        $removed = false;
        $lines = $this->lines;
        foreach ($lines as $line) {
            if ($line->removeName($nameIndex)) {
                $removed = true;
            }
        }
        $this->sMappings = null;
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
            if ($this->lines === null) {
                $this->parse();
            }
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
     * Returns a position map by a position in the generated source
     *
     * @param int $line
     *        zero-based line number in the generated source
     * @param int $column
     *        zero-bases column number is the line
     * @return \axy\sourcemap\PosMap|null
     *         A position map or NULL if it is not found
     */
    public function getPosition($line, $column)
    {
        if ($this->lines === null) {
            $this->parse();
        }
        if (!isset($this->lines[$line])) {
            return null;
        }
        return $this->lines[$line]->getPosition($column);
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
