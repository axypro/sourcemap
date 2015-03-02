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

    /**
     * covers ::loadFromFile
     */
    public function testLoadFromFile()
    {
        $map = SourceMap::loadFromFile(__DIR__.'/../tst/map.js.map');
        $this->assertInstanceOf('axy\sourcemap\SourceMap', $map);
        $expected = [
            'version' => 3,
            'file' => 'script.js',
            'sourceRoot' => '',
            'sources' => ['script.ts'],
            'names' => ['MyClass', 'constructor', 'initEvents', 'redraw', 'CW', 'CW.constructor'],
            'mappings' => "AAAA,YAAY,CAAC;;;;;;;AAEb,IAAO,GAAG,WAAW,OAAO,CAAC,CAAC",
        ];
        $this->assertEquals($expected, $map->getData());
        $this->assertSame('script.js', $map->file);
    }

    /**
     * covers ::loadFromFile
     * @expectedException \axy\sourcemap\errors\IO
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileNotFound()
    {
        return SourceMap::loadFromFile(__DIR__.'/../tst/notFound.js.map');
    }

    /**
     * covers ::loadFromFile
     * @expectedException \axy\sourcemap\errors\InvalidJSON
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileInvalidJSON()
    {
        return SourceMap::loadFromFile(__DIR__.'/../tst/invalid.json.js.map');
    }

    /**
     * covers ::loadFromFile
     * @expectedException \axy\sourcemap\errors\UnsupportedVersion
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileUnsupportedVersion()
    {
        return SourceMap::loadFromFile(__DIR__.'/../tst/version4.js.map');
    }
}
