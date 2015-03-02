<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\sourcemap\errors\OutFileNotSpecified;
use axy\sourcemap\parsing\FormatChecker;
use axy\sourcemap\parsing\Context;
use axy\sourcemap\indexed\Sources;
use axy\sourcemap\indexed\Names;
use axy\sourcemap\helpers\IO;
use axy\sourcemap\errors\UnsupportedVersion;
use axy\errors\FieldNotExist;
use axy\errors\ContainerReadOnly;
use axy\errors\PropertyReadOnly;

/**
 * The Source Map Class
 *
 * @property int $version
 *           the version of the file format
 * @property string $file
 *           the "file" section
 * @property string $sourceRoot
 *           the "sourceRoot" section
 * @property-read \axy\sourcemap\indexed\Sources $sources
 *                the "sources" section (wrapper)
 * @property-read \axy\sourcemap\indexed\Names $names
 *                the "names" section (wrapper)
 * @property string $outFileName
 *           the default file name of the map
 */
class SourceMap
{
    /**
     * The constructor
     *
     * @param array $data [optional]
     *        the map data
     * @param string $filename [optional]
     *        the default file name of the map
     * @throws \axy\sourcemap\errors\InvalidFormat
     *         the map has an invalid format
     */
    public function __construct(array $data = null, $filename = null)
    {
        $this->context = new Context(FormatChecker::check($data));
        $this->sources = new Sources($this->context);
        $this->names = new Names($this->context);
        $this->outFileName = $filename;
    }

    /**
     * Loads a source map from a file
     *
     * @param string $filename
     * @return \axy\sourcemap\SourceMap
     * @throws \axy\sourcemap\errors\IO
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
     * Returns the data of the json file
     *
     * @return array
     */
    public function getData()
    {
        $data = $this->context->data;
        return [
            'version' => 3,
            'file' => $data['file'] ?: '',
            'sourceRoot' => $data['sourceRoot'] ?: '',
            'sources' => $this->sources->getNames(),
            'names' => $this->names->getNames(),
            'mappings' => $data['mappings'], // @todo
        ];
    }

    /**
     * Magic isset()
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return in_array($key, ['version', 'file', 'sourceRoot', 'sources', 'names', 'mappings', 'outFileName']);
    }

    /**
     * Magic get
     *
     * @param string $key
     * @return mixed
     * @throws \axy\errors\FieldNotExist
     */
    public function __get($key)
    {
        switch ($key) {
            case 'version':
                return 3;
            case 'file':
            case 'sourceRoot':
                return $this->context->data[$key];
            case 'sources':
                return $this->sources;
            case 'names':
                return $this->names;
            case 'outFileName':
                return $this->outFileName;
        }
        throw new FieldNotExist($key, $this, null, $this);
    }

    /**
     * Magic set
     *
     * @param string $key
     * @param mixed $value
     * @throws \axy\errors\FieldNotExist
     * @throws \axy\errors\PropertyReadOnly
     */
    public function __set($key, $value)
    {
        switch ($key) {
            case 'version':
                if (($value === 3) || ($value === '3')) {
                    return;
                }
                throw new UnsupportedVersion($value);
            case 'file':
            case 'sourceRoot':
                $this->context->data[$key] = $value;
                break;
            case 'sources':
            case 'names':
                throw new PropertyReadOnly($this, $key, null, $this);
            case 'outFileName':
                $this->outFileName = $value;
                break;
            default:
                throw new FieldNotExist($key, $this, null, $this);
        }
    }

    /**
     * Magic unset
     *
     * @param string $key
     * @throws \axy\errors\ContainerReadOnly
     */
    public function __unset($key)
    {
        throw new ContainerReadOnly($this, null, $this);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[Source Map]';
    }

    /**
     * @var \axy\sourcemap\parsing\Context
     */
    private $context;

    /**
     * @var \axy\sourcemap\indexed\Sources
     */
    private $sources;

    /**
     * @var \axy\sourcemap\indexed\Names
     */
    private $names;

    /**
     * @var string
     */
    private $outFileName;
}
