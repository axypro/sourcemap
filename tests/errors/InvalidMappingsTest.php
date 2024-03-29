<?php

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\InvalidMappings;

/**
 * coversDefaultClass axy\sourcemap\errors\InvalidMappings
 */
class InvalidMappingsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::__construct
     * covers ::getErrorMessage
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new InvalidMappings('invalid segment "AAA"', $ep);
        $this->assertSame('Source map mappings is invalid: "invalid segment "AAA""', $e->getMessage());
        $this->assertSame('invalid segment "AAA"', $e->getErrorMessage());
        $this->assertSame($ep, $e->getPrevious());
    }
}
