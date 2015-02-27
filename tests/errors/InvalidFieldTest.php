<?php
/**
 * @package axy\sourcemap
 * @author Oleg Grigoriev <go.vasac@gmail.com>
 */

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\InvalidField;

/**
 * coversDefaultClass axy\sourcemap\errors\InvalidFieldTest
 */
class InvalidFieldTest extends \PHPUnit_Framework_TestCase
{
    /**
     * covers ::__construct
     * covers ::getVersion
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new InvalidField('source', 'must be an array', $ep);
        $this->assertSame('Source map field "source" is invalid: "must be an array"', $e->getMessage());
        $this->assertSame('source', $e->getField());
        $this->assertSame('must be an array', $e->getErrorMessage());
        $this->assertSame($ep, $e->getPrevious());
    }
}
