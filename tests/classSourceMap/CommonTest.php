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
class CommonTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getData
     * @return \axy\sourcemap\SourceMap
     */
    public function testCreate()
    {
        $map = new SourceMap();
        $expected = [
            'version' => 3,
            'file' => '',
            'sourceRoot' => '',
            'sources' => [],
            'names' => [],
            'mappings' => '',
        ];
        $this->assertEquals($expected, $map->getData());
        $this->setExpectedException('axy\sourcemap\errors\InvalidFormat');
        return new SourceMap(['version' => 5]);
    }

    /**
     * covers ::getData
     */
    public function testGetData()
    {
        $data = [
            'version' => 3,
            'file' => 'out.js',
            'sources' => ['a.js'],
            'mappings' => 'A;C',
        ];
        $expected = [
            'version' => 3,
            'file' => 'out.js',
            'sourceRoot' => '',
            'sources' => ['a.js'],
            'names' => [],
            'mappings' => 'A;C',
        ];
        $map = new SourceMap($data);
        $this->assertSame($expected, $map->getData());
    }
}
