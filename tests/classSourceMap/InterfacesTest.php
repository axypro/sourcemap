<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\classSourceMap;

use axy\sourcemap\SourceMap;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class InterfacesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $data = [
        'version' => 3,
        'file' => 'script.js',
        'sourceRoot' => '/js/',
        'sources' => ['a.js', 'b.js'],
        'names' => ['one', 'two', 'three', 'four', 'five', 'six'],
        'mappings' => 'AAAA,YAAY,CAAC;;;;;;;AAEb,IAAO,GAAG,WAAW,OAAO,CAAC,CAAC',
    ];

    /**
     * @var \axy\sourcemap\SourceMap
     */
    private $map;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->map = new SourceMap($this->data);
    }

    public function testIterator()
    {
        $actual = [];
        foreach ($this->map as $k => $v) {
            $actual[$k] = $v;
        }
        $this->assertEquals($this->data, $actual);
    }
}
