<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\parsing;

/**
 * Internal context of parsing and change of the source map
 */
class Context
{
    /**
     * The data of the source map file
     *
     * @var array
     */
    public $data;

    /**
     * An array from the "sources" section
     *
     * @var string[]
     */
    public $sources;

    /**
     * An array from the "names" section
     *
     * @var string[]
     */
    public $names;

    /**
     * The constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->sources = isset($data['sources']) ? $data['sources'] : [];
        $this->names = isset($data['names']) ? $data['names'] : [];
    }

    /**
     * Returns the data for JSON file
     *
     * @return array
     */
    public function getOutData()
    {
        $result = ['version' => 3];
        $fields = ['file', 'sourceRoot', 'sources', 'sourcesContent', 'names', 'mappings'];
        foreach ($fields as $field) {
            if (isset($this->data[$field])) {
                $value = $this->data[$field];
                if (is_array($value)) {
                    if (!empty($value)) {
                        $result[$field] = $value;
                    }
                } elseif (($value !== '') && ($value !== null)) {
                    $result[$field] = $value;
                }
            }
        }
        return $result;
    }
}
