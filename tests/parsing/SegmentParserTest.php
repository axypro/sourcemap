<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\parsing;

use axy\sourcemap\parsing\SegmentParser;

/**
 * coversDefaultClass axy\sourcemap\parsing\SegmentParser
 */
class SegmentParserTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::nextLine
     * covers ::parse
     */
    public function testParse()
    {
        $parser = new SegmentParser();
        $parser->nextLine(0);
        $pos1 = $parser->parse('AAAA');
        $this->assertInstanceOf('axy\sourcemap\PosMap', $pos1);
        $expected1 = [
            [
                'line' => 0,
                'column' => 0,
            ],
            [
                'fileIndex' => 0,
                'fileName' => null,
                'line' => 0,
                'column' => 0,
                'nameIndex' => null,
                'name' => null,
            ],
        ];
        $this->assertSame($expected1, [(array)$pos1->generated, (array)$pos1->source]);
        $pos2 = $parser->parse('CCCEC');
        $this->assertInstanceOf('axy\sourcemap\PosMap', $pos2);
        $expected2 = [
            [
                'line' => 0,
                'column' => 1,
            ],
            [
                'fileIndex' => 1,
                'fileName' => null,
                'line' => 1,
                'column' => 2,
                'nameIndex' => 1,
                'name' => null,
            ],
        ];
        $this->assertSame($expected2, [(array)$pos2->generated, (array)$pos2->source]);
        $parser->nextLine(3);
        $pos3 = $parser->parse('GACD');
        $this->assertInstanceOf('axy\sourcemap\PosMap', $pos3);
        $expected3 = [
            [
                'line' => 3,
                'column' => 3,
            ],
            [
                'fileIndex' => 1,
                'fileName' => null,
                'line' => 2,
                'column' => 1,
                'nameIndex' => null,
                'name' => null,
            ],
        ];
        $this->assertSame($expected3, [(array)$pos3->generated, (array)$pos3->source]);
    }

    /**
     * covers ::parse
     * @dataProvider providerParseError
     * @param string $segment
     * @expectedException \axy\sourcemap\errors\InvalidMappings
     */
    public function testParseError($segment)
    {
        $parser = new SegmentParser();
        $parser->parse($segment);
    }

    /**
     * @return array
     */
    public function providerParseError()
    {
        return [
            'empty' => [''],
            'count3' => ['AAA'],
            'count7' => ['AAAAAAA'],
            'base64' => ['AA*A'],
            'vlq' => ['AAAz'],
        ];
    }
}
