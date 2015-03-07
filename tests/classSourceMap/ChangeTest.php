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
class ChangeTest extends \PHPUnit_Framework_TestCase
{
    public function testFileRename()
    {
        $map = SourceMap::loadFromFile(__DIR__.'/../tst/app.js.map');
        $data = $map->getData();
        $map->sources->rename(0, 'new-carry.ts');
        $map->sources->rename(2, 'new-app.ts');
        $map->sources->rename(5, 'new-none.ts');
        $expected = $data;
        $expected['sources'][0] = 'new-carry.ts';
        $expected['sources'][2] = 'new-app.ts';
        $this->assertEquals($expected, $map->getData());
    }

    public function testNameRename()
    {
        $map = SourceMap::loadFromFile(__DIR__.'/../tst/map.js.map');
        $data = $map->getData();
        $map->names->rename(0, 'One');
        $map->names->rename(5, 'Two');
        $map->names->rename(55, 'Three');
        $expected = $data;
        $expected['names'][0] = 'One';
        $expected['names'][5] = 'Two';
        $this->assertEquals($expected, $map->getData());
    }
}
