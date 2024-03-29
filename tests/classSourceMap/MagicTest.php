<?php

namespace axy\sourcemap\tests\classSourceMap;

use axy\errors\PropertyReadOnly;
use axy\sourcemap\errors\UnsupportedVersion;
use axy\sourcemap\SourceMap;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class MagicTest extends \PHPUnit\Framework\TestCase
{
    public function testPropertyVersion()
    {
        $map = new SourceMap();
        $this->assertSame(3, $map->version);
        $this->assertTrue(isset($map->version));
        $map->version = 3;
        $map->version = '3';
        $this->assertSame(3, $map->version);
        $this->expectException(UnsupportedVersion::class);
        $map->version = 5;
    }

    public function testPropertyFile()
    {
        $map = new SourceMap(['version' => 3, 'file' => 'out.js', 'sources' => [], 'mappings' => 'A']);
        $this->assertTrue(isset($map->file));
        $this->assertSame('out.js', $map->file);
        $map->file = 'new.js';
        $this->assertSame('new.js', $map->file);
        $data = $map->getData();
        $this->assertSame('new.js', $data['file']);
    }

    public function testPropertySourceRoot()
    {
        $map = new SourceMap();
        $this->assertNull($map->sourceRoot);
        $map->sourceRoot = '/js/';
        $this->assertTrue(isset($map->sourceRoot));
        $this->assertSame('/js/', $map->sourceRoot);
        $data = $map->getData();
        $this->assertSame('/js/', $data['sourceRoot']);
    }

    public function testPropertySourcesNames()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two', 'three'],
            'mappings' => 'A',
        ];
        $map = new SourceMap($data);
        $this->assertTrue(isset($map->sources));
        $this->assertTrue(isset($map->names));
        $this->assertInstanceOf('axy\sourcemap\indexed\Sources', $map->sources);
        $this->assertInstanceOf('axy\sourcemap\indexed\Names', $map->names);
        $this->assertEquals(['a.js', 'b.js'], $map->sources->getNames());
        $this->assertEquals(['one', 'two', 'three'], $map->names->getNames());
        $this->expectException(PropertyReadOnly::class);
        $map->__set('sources', ['c.js']);
    }

    /**
     * covers ::__get
     *
     */
    public function testMagicGet()
    {
        $this->expectException(\axy\errors\FieldNotExist::class);
        $map = new SourceMap();
        $map->__get('abc');
    }

    /**
     * covers ::__set
     *
     */
    public function testMagicSet()
    {
        $this->expectException(\axy\errors\FieldNotExist::class);
        $map = new SourceMap();
        $map->__set('abc', 1);
    }

    /**
     * covers ::__unset
     *
     */
    public function testMagicUnset()
    {
        $this->expectException(\axy\errors\ContainerReadOnly::class);
        $map = new SourceMap();
        unset($map->version);
    }

    public function testMagicIsset()
    {
        $map = new SourceMap();
        $this->assertFalse(isset($map->abc));
        $this->assertFalse(isset($map->sourcesContent));
    }
}
