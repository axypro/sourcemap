<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev
 */

namespace axy\sourcemap;

use axy\sourcemap\parsing\FormatChecker;
use axy\sourcemap\parsing\Context;
use axy\sourcemap\indexed\Sources;
use axy\sourcemap\indexed\Names;
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
 */
class SourceMap
{
    /**
     * The constructor
     *
     * @param array $data [optional]
     * @throws \axy\sourcemap\errors\InvalidFormat
     */
    public function __construct(array $data = null)
    {
        $this->context = new Context(FormatChecker::check($data));
        $this->sources = new Sources($this->context);
        $this->names = new Names($this->context);
    }

    /**
     * Returns the data of the json file
     *
     * @return array
     */
    public function getData()
    {
        return $this->context->getOutData();
    }

    /**
     * Magic isset()
     *
     * @param string $key
     * @return bool
     */
    public function __isset($key)
    {
        return in_array($key, ['version', 'file', 'sourceRoot', 'sources', 'names', 'mappings']);
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
}
