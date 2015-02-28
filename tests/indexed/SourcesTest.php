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
}
