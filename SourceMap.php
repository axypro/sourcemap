<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\sourcemap\parents\Interfaces as ParentClass;
use axy\sourcemap\helpers\IO;
use axy\sourcemap\helpers\PosBuilder;
use axy\sourcemap\errors\OutFileNotSpecified;
use axy\sourcemap\errors\IncompleteData;

/**
 * The Source Map Class
 */
class SourceMap extends ParentClass
{
    /**
     * Loads a source map from a file
     *
     * @param string $filename
     * @return \axy\sourcemap\SourceMap
     * @throws \axy\sourcemap\errors\IOError
     * @throws \axy\sourcemap\errors\InvalidFormat
     */
    public static function loadFromFile($filename)
    {
        return new self(IO::loadJSON($filename), $filename);
    }

    /**
     * Saves the map file
     *
     * @param string $filename [optional]
     *        the map file name (by default used outFileName)
     * @param int $jsonFlag [optional]
     * @throws \axy\sourcemap\errors\IOError
     * @throws \axy\sourcemap\errors\OutFileNotSpecified
     */
    public function save($filename = null, $jsonFlag = JSON_UNESCAPED_SLASHES)
    {
        if ($filename === null) {
            if ($this->outFileName === null) {
                throw new OutFileNotSpecified();
            }
            $filename = $this->outFileName;
        }
        IO::saveJSON($this->getData(), $filename, $jsonFlag);
        $this->outFileName = $filename;
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
        return $this->context->getMappings()->getPosition($line, $column);
    }

    /**
     * Finds a position in the source files
     *
     * @param int $fileIndex
     * @param int $line
     * @param int $column
     * @return \axy\sourcemap\PosMap|null
     *         A position map or NULL if it is not found
     */
    public function findPositionInSource($fileIndex, $line, $column)
    {
        return $this->context->getMappings()->findPositionInSource($fileIndex, $line, $column);
    }

    /**
     * Finds positions that match to a filter
     *
     * @param \axy\sourcemap\PosMap|object|array $filter [optional]
     *        the filter (if not specified then returns all positions)
     * @return \axy\sourcemap\PosMap[]
     */
    public function find($filter = null)
    {
        if ($filter !== null) {
            $filter = PosBuilder::build($filter);
        }
        return $this->context->getMappings()->find($filter);
    }

    /**
     * Removes a position
     *
     * @param int $line
     *        zero-based line number in the generated source
     * @param int $column
     *        zero-bases column number is the line
     * @return bool
     *         TRUE if the position was found and removed
     */
    public function removePosition($line, $column)
    {
        return $this->context->getMappings()->removePosition($line, $column);
    }

    /**
     * Adds a position to the source map
     *
     * @param \axy\sourcemap\PosMap|array|object $position
     * @return \axy\sourcemap\PosMap
     * @throws \axy\sourcemap\errors\InvalidIndexed
     * @throws \axy\sourcemap\errors\IncompleteData
     */
    public function addPosition($position)
    {
        $position = PosBuilder::build($position);
        $generated = $position->generated;
        $source = $position->source;
        if ($generated->line === null) {
            throw new IncompleteData('required generated line number');
        }
        if ($generated->column === null) {
            throw new IncompleteData('required generated column number');
        }
        if ($this->sources->fillSource($source)) {
            if ($source->line === null) {
                throw new IncompleteData('required source line number');
            }
            if ($source->column === null) {
                throw new IncompleteData('required source column number');
            }
            $this->names->fillSource($source);
        }
        $this->context->getMappings()->addPosition($position);
        return $position;
    }

    /**
     * Inserts a block in the generated content
     *
     * @param int $sLine
     *        the line of the block start
     * @param int $sColumn
     *        the column of the block start
     * @param int $eLine
     *        the line of the block end
     * @param int $eColumn
     *        the line of the block end
     */
    public function insertBlock($sLine, $sColumn, $eLine, $eColumn)
    {
        $this->context->getMappings()->insertBlock($sLine, $sColumn, $eLine, $eColumn);
    }

    /**
     * Removes a block from the generated content
     *
     * @param int $sLine
     *        the line of the block start
     * @param int $sColumn
     *        the column of the block start
     * @param int $eLine
     *        the line of the block end
     * @param int $eColumn
     *        the line of the block end
     */
    public function removeBlock($sLine, $sColumn, $eLine, $eColumn)
    {
        $this->context->getMappings()->removeBlock($sLine, $sColumn, $eLine, $eColumn);
    }
}
