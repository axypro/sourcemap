<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\indexed;

use axy\sourcemap\indexed\Names;
use axy\sourcemap\parsing\Context;

/**
 * coversDefaultClass axy\sourcemap\indexed\Names
 */
class NamesTest extends \PHPUnit_Framework_TestCase
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
        $names = new Names($context);
        $this->assertEquals(['one', 'two'], $names->getNames());
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
            'mappings' => 'AAAAA,CAAAC',
        ];
        $context = new Context($data);
        $names = new Names($context);
        $this->assertEquals(['one', 'two'], $names->getNames());
        $pos0 = $context->getMappings()->getLines()[0]->getPositions()[0];
        $pos1 = $context->getMappings()->getLines()[0]->getPositions()[1];
        $this->assertSame('one', $pos0->source->name);
        $this->assertSame('two', $pos1->source->name);
        $this->assertTrue($names->rename('1', 'three'));
        $this->assertFalse($names->rename('1', 'three'));
        $this->assertFalse($names->rename(10, 'three'));
        $this->assertEquals(['one', 'three'], $names->getNames());
        $this->assertSame('one', $pos0->source->name);
        $this->assertSame('three', $pos1->source->name);
    }
}
