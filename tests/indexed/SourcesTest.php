<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\indexed;

use axy\sourcemap\indexed\Sources;
use axy\sourcemap\parsing\Context;

/**
 * coversDefaultClass axy\sourcemap\indexed\Sources
 */
class SourcesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getNames
     */
    public function testGetNames()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two'],
            'mappings' => 'A',
        ];
        $context = new Context($data);
        $sources = new Sources($context);
        $this->assertEquals(['a.js', 'b.js'], $sources->getNames());
    }

    /**
     * covers ::rename
     */
    public function testRename()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two'],
            'mappings' => 'AAAAA,CCAAC',
        ];
        $context = new Context($data);
        $sources = new Sources($context);
        $this->assertEquals(['a.js', 'b.js'], $sources->getNames());
        $pos0 = $context->mappings->getLines()[0]->getPositions()[0];
        $pos1 = $context->mappings->getLines()[0]->getPositions()[1];
        $this->assertSame('a.js', $pos0->source->fileName);
        $this->assertSame('b.js', $pos1->source->fileName);
        $sources->rename(0, 'c.js');
        $this->assertEquals(['c.js', 'b.js'], $sources->getNames());
        $this->assertSame('c.js', $pos0->source->fileName);
        $this->assertSame('b.js', $pos1->source->fileName);
    }
}
