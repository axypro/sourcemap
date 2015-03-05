<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\parsing;

use axy\sourcemap\parsing\Mappings;
use axy\sourcemap\parsing\Context;
use axy\sourcemap\PosMap;
use axy\sourcemap\tests\Represent;

/**
 * coversDefaultClass axy\sourcemap\parsing\Mappings
 */
class MappingsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $struct = [
        0 =>  [
            0 => [
                'generated' => [
                    'line' => 0,
                    'column' => 0,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 0,
                    'column' => 0,
                    'nameIndex' => null,
                    'name' => null,
                ],
            ],
            12 => [
                'generated' => [
                    'line' => 0,
                    'column' => 12,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 0,
                    'column' => 12,
                    'nameIndex' => null,
                    'name' => null,
                ],
            ],
            13 => [
                'generated' => [
                    'line' => 0,
                    'column' => 13,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 0,
                    'column' => 13,
                    'nameIndex' => null,
                    'name' => null,
                ],
            ],
        ],
        8 => [
            0 => [
                'generated' => [
                    'line' => 8,
                    'column' => 0,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 2,
                    'column' => 0,
                    'nameIndex' => null,
                    'name' => null,
                ],
            ],
            4 => [
                'generated' => [
                    'line' => 8,
                    'column' => 4,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 2,
                    'column' => 7,
                    'nameIndex' => 1,
                    'name' => 'two',
                ],
            ],
            7 => [
                'generated' => [
                    'line' => 8,
                    'column' => 7,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 2,
                    'column' => 10,
                    'nameIndex' => null,
                    'name' => null,
                ],
            ],
            18 => [
                'generated' => [
                    'line' => 8,
                    'column' => 18,
                ],
                'source' => [
                    'fileIndex' => 0,
                    'fileName' => 'a.js',
                    'line' => 2,
                    'column' => 21,
                    'nameIndex' => 3,
                    'name' => 'four',
                ],
            ],
        ],
    ];

    /**
     * covers ::__construct
     * covers ::getLines
     */
    public function testParse()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two', 'three', 'four', 'five'],
            'mappings' => 'A',
        ];
        $context = new Context($data);
        $mappings = new Mappings('AAAA,YAAY,CAAC;;;;;;;;AAEb,IAAOC,GAAG,WAAWE', $context);
        $this->assertEquals($this->struct, Represent::mappings($mappings));
    }

    /**
     * covers ::addPosition
     */
    public function testAddPosition()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two', 'three', 'four', 'five'],
            'mappings' => 'A',
        ];
        $context = new Context($data);
        $mappings = new Mappings('', $context);
        $this->assertEquals([], $mappings->getLines());
        foreach ($this->struct as $line) {
            foreach ($line as $position) {
                $mappings->addPosition(new PosMap($position['generated'], $position['source']));
            }
        }
        $this->assertEquals($this->struct, Represent::mappings($mappings));
    }

    public function testRemovePosition()
    {
        $data = [
            'version' => 3,
            'sources' => ['a.js', 'b.js'],
            'names' => ['one', 'two', 'three', 'four', 'five'],
            'mappings' => 'A',
        ];
        $context = new Context($data);
        $mappings = new Mappings('AAAA,YAAY,CAAC;;;;;;;;AAEb,IAAOC,GAAG,WAAWE', $context);
        $this->assertFalse($mappings->removePosition(3, 5));
        $this->assertTrue($mappings->removePosition(8, 4));
        $this->assertFalse($mappings->removePosition(8, 4));
        $expected = $this->struct;
        unset($expected[8][4]);
        $this->assertEquals($expected, Represent::mappings($mappings));
    }
}
