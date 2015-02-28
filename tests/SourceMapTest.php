<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests;

use axy\sourcemap\SourceMap;
use axy\sourcemap\parsing\FormatChecker;

/**
 * coversDefaultClass axy\sourcemap\SourceMap
 */
class SourceMapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getData
     * @return \axy\sourcemap\SourceMap
     */
    public function testCreate()
    {
        $map = new SourceMap();
        $this->assertEquals(['version' => 3], $map->getData());
        $this->setExpectedException('axy\sourcemap\errors\InvalidFormat');
        return new SourceMap(['version' => 5]);
    }
}
