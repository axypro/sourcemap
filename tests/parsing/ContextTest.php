<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\parsing;

use axy\sourcemap\parsing\Context;

/**
 * coversDefaultClass axy\sourcemap\parsing\Context
 */
class ContextTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     */
    public function testCreate()
    {
        $data = [
            'version' => 3,
            'file' => 'out.js',
            'sources' => ['a.js'],
            'names' => [],
            'mappings' => 'AAAA',
        ];
        $context = new Context($data);
        $this->assertEquals($data, $context->data);
    }

    /**
     * covers ::getOutData
     * @dataProvider providerGetOutData
     * @param array $input
     * @param array $output
     */
    public function testGetOutData(array $input, array $output)
    {
        $context = new Context($input);
        $this->assertEquals($output, $context->getOutData());
    }

    /**
     * @return array
     */
    public function providerGetOutData()
    {
        return [
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => '/js/',
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => [null, 'B contents'],
                    'names' => ['one', 'two'],
                    'mappings' => 'AAAAA;ACAC',
                ],
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => '/js/',
                    'sources' => ['a.js', 'b.js'],
                    'sourcesContent' => [null, 'B contents'],
                    'names' => ['one', 'two'],
                    'mappings' => 'AAAAA;ACAC',
                ],
            ],
            [
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sourceRoot' => '',
                    'sources' => ['a.js', 'b.js'],
                    'names' => [],
                    'mappings' => 'AAAAA;ACAC',
                ],
                [
                    'version' => 3,
                    'file' => 'out.js',
                    'sources' => ['a.js', 'b.js'],
                    'mappings' => 'AAAAA;ACAC',
                ],
            ],
        ];
    }
}
