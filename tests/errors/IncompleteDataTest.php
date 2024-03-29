<?php

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\IncompleteData;

/**
 * coversDefaultClass axy\sourcemap\errors\IncompleteData
 */
class IncompleteDataTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::__construct
     * covers ::getErrorMessage
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new IncompleteData('required line number', $ep);
        $this->assertSame('Input data is incomplete: "required line number"', $e->getMessage());
        $this->assertSame('required line number', $e->getErrorMessage());
        $this->assertSame($ep, $e->getPrevious());
    }
}
