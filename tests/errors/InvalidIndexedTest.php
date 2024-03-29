<?php

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\InvalidIndexed;

/**
 * coversDefaultClass axy\sourcemap\errors\InvalidIndexed
 */
class InvalidIndexedTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::__construct
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new InvalidIndexed('Error message', 3, $ep);
        $this->assertSame('Error message', $e->getMessage());
        $this->assertSame(3, $e->getCode());
        $this->assertSame($ep, $e->getPrevious());
    }
}
