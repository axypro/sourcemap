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
     * The constructor
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
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
