<?php

namespace axy\sourcemap\tests\errors;

use axy\sourcemap\errors\OutFileNotSpecified;

/**
 * coversDefaultClass axy\sourcemap\errors\OutFileNotSpecifiedTest
 */
class OutFileNotSpecifiedTest extends \PHPUnit\Framework\TestCase
{
    /**
     * covers ::__construct
     */
    public function testError()
    {
        $ep = new \RuntimeException();
        $e = new OutFileNotSpecified($ep);
        $this->assertSame('The default file name of the map is not specified', $e->getMessage());
        $this->assertSame($ep, $e->getPrevious());
    }
}
