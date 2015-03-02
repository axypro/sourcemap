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
        $this->assertEquals($data['sources'], $context->sources);
        $this->assertEquals($data['names'], $context->names);
    }
}
