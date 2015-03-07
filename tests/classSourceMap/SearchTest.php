<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\classSourceMap;

use axy\sourcemap\SourceMap;
use axy\sourcemap\tests\Represent;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class SearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::getPosition
     */
    public function testGetPosition()
    {
        $map = SourceMap::loadFromFile(__DIR__.'/../tst/app.js.map');
        $pos = $map->getPosition(1, 21);
        $this->assertInstanceOf('axy\sourcemap\PosMap', $pos);
        $expected = [
            'generated' => [
                'line' => 1,
                'column' => 21,
            ],
            'source' => [
                'fileIndex' => 0,
                'fileName' => 'carry.ts',
                'line' => 5,
                'column' => 20,
                'nameIndex' => 0,
                'name' => 'carry',
            ],
        ];
        $this->assertEquals($expected, Represent::posMap($pos));
        $this->assertSame($pos, $map->getPosition(1, 21));
        $this->assertNull($map->getPosition(2, 10));
        $this->assertNull($map->getPosition(200, 10));
    }

    /**
     * covers ::findPositionInSource
     */
    public function testFindPositionInSource()
    {
        $map = SourceMap::loadFromFile(__DIR__.'/../tst/app.js.map');
        $pos = $map->findPositionInSource(1, 1, 35);
        $this->assertInstanceOf('axy\sourcemap\PosMap', $pos);
        $expected = [
            'generated' => [
                'line' => 5,
                'column' => 37,
            ],
            'source' => [
                'fileIndex' => 1,
                'fileName' => 'funcs.ts',
                'line' => 1,
                'column' => 35,
                'nameIndex' => null,
                'name' => null,
            ],
        ];
        $this->assertEquals($expected, Represent::posMap($pos));
        $this->assertSame($pos, $map->findPositionInSource(1, 1, 35));
        $this->assertNull($map->findPositionInSource(1, 1, 36));
        $this->assertNull($map->findPositionInSource(1, 100, 36));
        $this->assertNull($map->findPositionInSource(100, 1, 36));

    }
}
