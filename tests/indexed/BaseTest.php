<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\indexed;

use axy\sourcemap\indexed\Names;
use axy\sourcemap\parsing\Context;

/**
 * coversDefaultClass axy\sourcemap\indexed\Base
 * Abstract class is tested using Names class
 */
class BaseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var array
     */
    private $defaultData = [
        'version' => 3,
        'sources' => 'a.js',
        'names' => ['one', 'two', 'three', 'four'],
        'mappings' => 'A',
    ];

    /**
     * @param array $data [optional]
     * @return \axy\sourcemap\indexed\Base
     */
    private function createIndexed(array $data = null)
    {
        return new Names(new Context($data ?: $this->defaultData));
    }

    /**
     * covers ::__construct
     * covers ::getNames
     */
    public function testGetNames()
    {
        $this->assertEquals(['one', 'two', 'three', 'four'], $this->createIndexed()->getNames());
    }
}
