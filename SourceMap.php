<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\sourcemap\parents\Interfaces as ParentClass;
use axy\sourcemap\helpers\IO;
use axy\sourcemap\errors\OutFileNotSpecified;

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
}
