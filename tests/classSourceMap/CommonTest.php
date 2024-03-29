<?php

namespace axy\sourcemap\tests\classSourceMap;

use axy\sourcemap\errors\InvalidFormat;
use axy\sourcemap\errors\InvalidJSON;
use axy\sourcemap\errors\IOError;
use axy\sourcemap\errors\OutFileNotSpecified;
use axy\sourcemap\errors\UnsupportedVersion;
use axy\sourcemap\SourceMap;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class CommonTest extends \PHPUnit\Framework\TestCase
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
        $this->expectException(InvalidFormat::class);
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
        $map = SourceMap::loadFromFile(__DIR__ . '/../tst/map.js.map');
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
     *
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileNotFound()
    {
        $this->expectException(IOError::class);

        return SourceMap::loadFromFile(__DIR__ . '/../tst/notFound.js.map');
    }

    /**
     * covers ::loadFromFile
     *
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileInvalidJSON()
    {
        $this->expectException(InvalidJSON::class);

        return SourceMap::loadFromFile(__DIR__ . '/../tst/invalid.json.js.map');
    }

    /**
     * covers ::loadFromFile
     *
     * @return \axy\sourcemap\SourceMap
     */
    public function testLoadFromFileUnsupportedVersion()
    {
        $this->expectException(UnsupportedVersion::class);

        return SourceMap::loadFromFile(__DIR__ . '/../tst/version4.js.map');
    }

    /**
     * covers ::save
     */
    public function testSave()
    {
        $data = [
            'version' => 3,
            'file' => 'script.js',
            'sourceRoot' => '',
            'sources' => ['a.js', 'b.js'],
            'names' => ['one'],
            'mappings' => 'A',
        ];
        $map = new SourceMap($data);
        $fn = __DIR__ . '/../../local/tmp/test.map';
        if (is_file($fn)) {
            unlink($fn);
        }
        $map->save($fn);
        $this->assertFileExists($fn);
        $this->assertEquals($data, json_decode(file_get_contents($fn), true));
        $this->expectException(IOError::class);
        $map->save(__DIR__ . '/../../local/tmp/und/und.map');
    }

    public function testOutFileName()
    {
        $map1 = new SourceMap();
        $this->assertNull($map1->outFileName);
        $fn = __DIR__ . '/../../local/tmp/test.map';
        if (is_file($fn)) {
            unlink($fn);
        }
        $map1->sourceRoot = '/root/js/';
        $map1->outFileName = $fn;
        $this->assertSame($fn, $map1->outFileName);
        $map2 = new SourceMap(null, $fn);
        $this->assertSame($fn, $map2->outFileName);
        $map1->save();
        $map3 = SourceMap::loadFromFile($fn);
        $this->assertSame($fn, $map3->outFileName);
        $this->assertSame('/root/js/', $map3->sourceRoot);
        $fn2 = __DIR__ . '/../../local/tmp/test2.map';
        if (is_file($fn2)) {
            unlink($fn2);
        }
        $map3->outFileName = $fn2;
        $this->assertSame($fn2, $map3->outFileName);
        unlink($fn);
        $map3->save();
        $map3->save($fn);
        $this->assertSame($fn, $map3->outFileName);
        $json1 = json_decode(file_get_contents($fn), true);
        $json2 = json_decode(file_get_contents($fn2), true);
        $this->assertSame('/root/js/', $json1['sourceRoot']);
        $this->assertSame('/root/js/', $json2['sourceRoot']);
        $map3->outFileName = null;
        $this->expectException(OutFileNotSpecified::class);
        $map3->save();
    }
}
